<?php
/**
 * @name BidManager.php
 * @author wxweven wxweven@163.com
 * Date 2013-11-27 
 * Encoding UTF-8
 */
class BidManager extends CApplicationComponent{
	
	/**
	 * 获取标段详情
	 * @param integer $bidId
	 * @param string $condition
	 * @param array $params
	 */
	public function getBidInfo($bidId,$condition='',$params=array()) {
		return BidInfo::model()->with('user')->findByPk( $bidId ,$condition,$params);
	}
	
	/**
	 * 获取投标详情
	 * @param integer $metaId
	 * @param string $condition
	 * @param array $params
	 */
	public function getBidMetaInfo($metaId,$condition='',$params=array()){
		return BidMeta::model()->with('user','bid')->findByPk($metaId,$condition,$params);
	}
	
	/**
	 * 标段列表
	 * @param string $condition
	 * @param array $params
	 */
	public function getBidList($condition, $params = array()){
		return BidInfo::model()->findAll($condition,$params);
	}
	
	/**
	 * 投资列表
	 * @param string $condition
	 * @param array $params
	 */
	public function getBidMetaList($condition, $params = array()){
		return BidMeta::model()->with('user','bid')->findAll($condition,$params);
	}
	
	/**
	 * 获取锁定资金
	 * @param integer $uid
	 * @return number
	 */
	public function getLockBalance($uid){
		$progress = BidMeta::model()->find(array(
			'select' => 'SUM(sum) AS sum',
			'condition' => 'status=21 AND user_id='.$uid
		));
		
		return $progress->getAttribute('sum') / 100;
	}
	
	/**
	 * 计算每月还款金额
	 * @param float $sum
	 * @param float $rate  月利率
	 * @param integer $deadline
	 * @return number
	 */
	public function calculateRefund($sum,$rate,$deadline){
		$pow = pow(1 + $rate / 100,$deadline);
		$n = $sum * $rate / 100 * $pow;
		$m = $pow - 1;
		return round($n / $m ,2);
	}
	
	/**
	 * 发标
	 * @param integer $user
	 * @param string $title
	 * @param string $description
	 * @param double $sum
	 * @param double $rate
	 * @param integer $start
	 * @param integer $end
	 * @param integer $deadline
	 * @return boolean
	 */
	public function raiseBid($user,$title,$description,$sum,$rate,$start,$end,$deadline){
		$sum = round($sum,2);
		$rate = round($rate,2);
		
		$bid = new BidInfo();
		//$refund = $this->calculateRefund($sum, $rate / 1200, $deadline) * 100;
		$bid->attributes = array(
			'user_id' => $user,
			'title' => $title,
			'description' => $description,
			'sum' => $sum * 100,
			'refund' => $this->calculateRefund($sum, $rate / 12, $deadline) * 100,
			'month_rate' => $rate * 100,
			'start' => $start,
			'end' => $end,
			'deadline' => $deadline,
			'repay_deadline' => $deadline,
			'pub_time' => time(),
			'progress' => 0,
			'verify_progress' => 11, // 提交待审
		);
		
		if($bid->save()){
			return $bid->getPrimaryKey();
		}else{
			return 0;
		}
	}
	
	/**
	 * 后台审核Bid
	 * @param integer $bid
	 * @param string $message
	 */
	public function handleBid($bid,$message = null){
		$time = time();
		if(empty($message)){
			return BidInfo::model()->updateByPk($bid,array(
				'verify_progress' => 21,
				'begin_time' => $time
			)); // 开始招标
		} else {
			return BidInfo::model()->updateByPk($bid,array(
				'verify_progress' => 20,
				'begin_time' => $time,
				'repay_time' => $time,
				'finish_time' => $time,
				'failed_description' => $message
			));
		}
	}
	
	/**
	 * 满标
	 * @param integer $bid_id
	 * @return boolean
	 */
	public function compeleteBid($bid_id){
		if($bid_id instanceof CActiveRecord){
			$bid = $bid_id;
		}else{
			$bid = $this->getBidInfo($bid_id);
		}
		
		$metas = $this->getBidMetaList(array(
			'condition' => 'bid_id='.$bid->getAttribute('id')
		));
		
		$time = time();
		$fund = Yii::app()->getModule('pay')->fundManager;
		//费用计算
		$credit = Yii::app()->getModule('credit')->userCreditManager;
		$rate = $credit->userRateGet($bid->getAttribute('user_id'));
		
		if($bid->getAttribute('deadline') > 6){
			$fee = round($bid->getAttribute('refund') * $rate['on_over6'],2);
			$rate['on_bid'] = $rate['on_over6'];
		}else{
			$fee = round($bid->getAttribute('refund') * $rate['on_below6'],2);
			$rate['on_bid'] = $rate['on_below6'];
		}
		
		
		$transaction = Yii::app()->db->beginTransaction();
		try{
			//借款人收款
			$bid->getRelated('user')->saveCounters(array(
				'balance' => $bid->getAttribute('sum') - $fee * 100
			));
			
			foreach($metas as $meta){
				//投资状态更换
				switch ($meta->getAttribute('status')){
					case 11: // 订单状态
						$meta->attributes = array(
							'pay_time' => $time,
							'repay_time' => $time,
							'finish_time' => $time,
							'status' => 20
						);
					break;
					case 21: // 已付款
						$meta->attributes = array(
							'repay_time' => $time,
							'status' => 31
						);
					break;
				}
				$meta->save();
				
				//借款人收款记录
				$fund->p2p($bid->getAttribute('user_id'),
						$meta->getAttribute('user_id'),
						$meta->getAttribute('refund'),
						round($meta->getAttribute('refund') * $rate['on_bid'],2));
			}
			
			//标段状态更换 已满标开始还款
			$bid->attributes = array(
				'repay_time' => $time,
				'verify_progress' => 31
			);
			$bid->save();
			
			//@TODO 满标通知
			
			$transaction->commit();
			return true;
		}catch (Exception $e){
			$transaction->rollback();
			return false;
		}
	}
	
	/**
	 * 流标
	 * @param integer $bid_id
	 * @return boolean
	 */
	public function revokeBid($bid_id){
		if($bid_id instanceof CActiveRecord){
			$bid = $bid_id;
		}else{
			$bid = $this->getBidInfo($bid_id);
		}
		
		$time = time();
		
		$metas = $this->getBidMetaList(array(
			'condition' => 'bid_id='.$bid->getAttribute('id')
		));
		
		$transaction = Yii::app()->db->beginTransaction();
		try{
			foreach($metas as $meta){
				//投资状态更换
				if($meta->getAttribute('status') == 21){
					$meta->getRelated('user')->saveCounters(array(
						'balance' => $meta->getAttribute('sum')
					));
				}
				$meta->attributes = array(
					'repay_time' => $time,
					'finish_time' => $time,
					'status' => 30 // 订单关闭
				);
				$meta->save();
			}
			
			//标段状态更换
			$bid->attributes = array(
				'repay_time' => $time,
				'finish_time' => $time,
				'verify_progress' => 30 // 流标
			);
			$bid->save();
			
			$transaction->commit();
			return true;
		}catch(Exception $e){
			$transaction->rollback();
			return false;
		}
	}
	
	/**
	 * 还款
	 * @param integer $bid_id
	 * @return boolean
	 */
	public function repayBid($bid_id){
		if($bid_id instanceof CActiveRecord){
			$bid = $bid_id;
		}else{
			$bid = $this->getBidInfo($bid_id);
		}
		
		$fund = Yii::app()->getModule('pay')->fundManager;
		$credit = Yii::app()->getModule('credit')->userCreditManager;
		
		$metas = $this->getBidMetaList(array(
			'condition' => 'bid_id='.$bid->getAttribute('id')
		));
		
		$transaction = Yii::app()->db->beginTransaction();
		try{
			//借款人扣款
			$bid->getRelated('user')->saveCounters(array(
				'balance' => - $bid->getAttribute('refund'),
			));
			
			foreach($metas as $meta){				
				//费用计算
				$rate = $credit->userRateGet($meta->getAttribute('user_id'));
				$fee = round($meta->getAttribute('refund') * $rate['on_pay_back'],2);
				
				//投资人收款
				$meta->getRelated('user')->saveCounters(array(
					'balance' => $meta->getAttribute('refund') - $fee * 100
				));
				
				//投资人收款记录
				$fund->p2p($meta->getAttribute('user_id'),
						$bid->getAttribute('user_id'),
						$meta->getAttribute('refund'),
						$fee);
			}
			
			//还款期限 递减
			$bid->saveCounters(array(
				'repay_deadline' => -1,
			));
		
			$transaction->commit();
			
			//判断还款是否全部完成
			if(!$bid->getAttribute('repay_deadline')){
				$this->finishBid($bid);
			}
			return true;
		}catch(Exception $e){
			$transaction->rollback();
			return false;
		}
	}
	
	/**
	 * 还款完成
	 * @param integer $bid_id
	 * @return boolean
	 */
	public function finishBid($bid_id){
		if($bid_id instanceof CActiveRecord){
			$bid = $bid_id;
		}else{
			$bid = $this->getBidInfo($bid_id);
		}
		
		$time = time();
		
		$metas = $this->getBidMetaList(array(
			'condition' => 'bid_id='.$bid->getAttribute('id')
		));
		
		$transaction = Yii::app()->db->beginTransaction();
		try{
			//投资状态更换
			foreach($metas as $meta){
				$meta->attributes = array(
					'finish_time' => $time,
					'status' => 41 // 订单完成
				);
				$meta->save();
			}
		
			//标段状态更换
			$bid->attributes = array(
				'finish_time' => $time,
				'verify_progress' => 41 // 完成
			);
			$bid->save();
				
			$transaction->commit();
			return true;
		}catch(Exception $e){
			$transaction->rollback();
			return false;
		}
	}
	
	/**
	 * 投标 - 同时锁定标段进度。
	 * @param integer $user_id
	 * @param integer $bid_id
	 * @param integer $sum
	 * @return boolean
	 */
	public function purchaseBid($user_id,$bid_id,$sum){
		$sum = round($sum,2);
		
		$bid = $this->getBidInfo($bid_id);
		
		$meta = new BidMeta();
		$meta->attributes = array(
			'user_id' => $user_id,
			'bid_id' => $bid_id,
			'sum' => $sum * 100,
			'refund' => $this->calculateRefund($sum, $bid->getAttribute('month_rate') / 1200, $bid->getAttribute('deadline')) * 100,
			'buy_time' => time(),
			'status' => 11 // 订单未支付
		);
		
		if($meta->save()){
			return $meta->getPrimaryKey();
		}else{
			return 0;
		}
	}
	
	/**
	 * 投标付款 - 完成投标过程
	 * @param integer $meta_no
	 * @return boolean
	 */
	public function payPurchasedBid($meta_no){
		if($meta_no instanceof CActiveRecord){
			$meta = $meta_no;
		}else{
			$meta = $this->getBidMetaInfo($meta_no);
		}
		if(empty($meta) || $meta->getAttribute('status') != 11) return false;
		
		$bid = $meta->getRelated('bid');
		
		if($bid->getAttribute('progress_sum') + $meta->getAttribute('sum') > $bid->getAttribute('sum')) return false;
		
		$transaction = Yii::app()->db->beginTransaction();
		try{
			$meta->getRelated('user')->saveCounters(array(
				'balance' => - $meta->getAttribute('sum')
			));

			$bid->saveCounters(array(
				'progress_sum' => $meta->getAttribute('sum') * 100, 
				'progress' => ($meta->getAttribute('sum') * 10000) / $bid->getAttribute('sum')
			));
			
			$meta->attributes = array(
				'pay_time' => time(),
				'status' => 21 //订单已付款
			);
			$meta->save();
			
			$transaction->commit();
			
			//满标处理
			if($bid->getAttribute('progress_sum') + $meta->getAttribute('sum') == $bid->getAttribute('sum')){
				$this->compeleteBid($bid);
			}
			return true;
		}catch (Exception $e){
			$transaction->rollback();
			return false;
		}
	}
	
	/**
	 * 撤销投标 - 交易关闭
	 * @param integer $meta_no
	 * @return boolean
	 */
	public function revokePurchasedBid($meta_no){
		if($meta_no instanceof CActiveRecord){
			$meta = $meta_no;
		}else{
			$meta = $this->getBidMetaInfo($meta_no);
		}
		if(empty($meta) || $meta->getAttribute('status') != 11) return false;
		
		$time = time();
		
		$meta->attributes = array(
			'pay_time' => $time,
			'repay_time' => $time,
			'finish_time' => $time,
			'status' => 20 // 取消订单
		);
		
		if($meta->save()){
			return $meta->getPrimaryKey();
		}else{
			return 0;
		}
	}
}