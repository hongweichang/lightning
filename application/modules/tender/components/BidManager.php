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
//			'month_rate' => $rate,
			'start' => $start,
			'end' => $end,
			'deadline' => $deadline,
			'pub_time' => time(),
			'progress' => 0,
			'verify_progress' => 11, // 提交待审
			//'refund'=>$refund
		);
		
		if($bid->save()){
			return $bid->getPrimaryKey();
		}else{
			return 0;
			//var_dump($bid->getErrors());
		}
	}
	
	/**
	 * 后台审核Bid
	 * @param integer $bid
	 * @param string $message
	 */
	public function handleBid($bid,$message = null){
		if(empty($message)){
			return BidInfo::model()->updateByPk($bid,array('verify_progress' => 21)); // 开始招标
		} else {
			return BidInfo::model()->updateByPk($bid,array(
					'verify_progress' => 20,
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
		
		$transaction = Yii::app()->db->beginTransaction();
		try{		
			foreach($metas as $meta){
				switch ($meta->getAttribute('status')){
					case 11:
						$meta->attributes = array(
							//'finish_time' => time(),
							'status' => 20
						);
					break;
					case 21:
						$meta->attributes = array(
							'status' => 31
						);
					break;
				}
				$meta->save();
			}
			
			$bid->attributes = array(
					'verify_progress' => 31
			);
			$bid->save();
			
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
		
		$metas = $this->getBidMetaList(array(
				'condition' => 'bid_id='.$bid->getAttribute('id')
		));
		
		$transaction = Yii::app()->db->beginTransaction();
		try{
			foreach($metas as $meta){
				if($meta->getAttribute('status') == 21){
					$meta->getRelated('user')->saveCounters(array(
						'balance' => $meta->getAttribute('sum')
					));
				}
				$meta->attributes = array(
					'finish_time' => time(),
					'status' => 30 // 订单关闭
				);
				$meta->save();
			}
	
			$bid->attributes = array(
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
		
		$fund = $this->app->getModule('pay')->fundManager;
		
		$metas = $this->getBidMetaList(array(
			'condition' => 'bid_id='.$bid->getAttribute('id')
		));
		
		$transaction = Yii::app()->db->beginTransaction();
		try{
			$bid->getRelated('user')->saveCounters(array(
				'balance' => - $bid->getAttribute('refund')
			));
			
			foreach($metas as $meta){
				$meta->getRelated('user')->saveCounters(array(
					'balance' => $meta->getAttribute('refund')
				));
				
				$fund->p2p($bid->getAttribute('user_id'),
						$meta->getAttribute('user_id'),
						$meta->getAttribute('refund'),
						$meta->getAttribute('refund') * 0.01);
			}
		
			$transaction->commit();
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
		
		$metas = $this->getBidMetaList(array(
			'condition' => 'bid_id='.$bid->getAttribute('id')
		));
		
		$transaction = Yii::app()->db->beginTransaction();
		try{
			foreach($metas as $meta){
				$meta->attributes = array(
					'finish_time' => time(),
					'status' => 41 // 订单完成
				);
				$meta->save();
			}
		
			$bid->attributes = array(
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
		
		$transaction = Yii::app()->db->beginTransaction();
		try{
			$bid = $this->getBidInfo($bid_id);
			if(empty($bid)) return false;
			
			if($bid->getAttribute('progress_sum') + $sum * 100 > $bid->getAttribute('sum')) return false;
			
			$progress = ($sum * 10000) / $bid->getAttribute('sum');
			if($bid->getAttribute('progress_sum') + $sum * 100 != $bid->getAttribute('sum')){
				$progress = 100;
			}
			$bid->saveCounters(array(
				'progress_sum' => $sum * 100,  // 锁定进度
				'progress' => $progress
			));
			
			$meta = new BidMeta();
			$meta->attributes = array(
				'user_id' => $user_id,
				'bid_id' => $bid_id,
				'sum' => $sum * 100,
				'refund' => $this->calculateRefund($sum, $bid->getAttribute('month_rate') / 1200, $bid->getAttribute('deadline')) * 100,
				'buy_time' => time(),
				'status' => 11 // 订单未支付
			);
			$meta->save();
			$transaction->commit();
			return $meta->getPrimaryKey();
		}catch(Exception $e){
			$transaction->rollback();
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
		
		$user = $meta->getRelated('user');
		
		$transaction = Yii::app()->db->beginTransaction();
		try{
			$user->saveCounters(array(
				'balance' => - $meta->getAttribute('sum')
			));
			
			$meta->attributes = array(
				'finish_time' => time(),
				'status' => 21 //订单已付款
			);
			$meta->save();
			$transaction->commit();
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
		if(empty($meta) || $meta->getAttribute('status') != 11 || $meta->getAttribute('status') != 21) return false;
		
		$bid = $meta->getRelated('bid');
		
		$transaction = Yii::app()->db->beginTransaction();
		try{
			$bid->saveCounters(array(
				'progress' => - $meta->getAttribute('sum') * 100 / $bid->getAttribute('sum'),
				'progress_sum' => - $meta->getAttribute('sum')
			));
			
			if($meta->getAttribute('status') == 21){
				$meta->getRelated('user')->saveCounters(array(
					'balance' => $meta->getAttribute('sum')
				));
			}
		
			$meta->attributes = array(
				'finish_time' => time(),
				'status' => 20 // 取消订单
			);
			$meta->save();
			$transaction->commit();
			return true;
		}catch (Exception $e){
			$transaction->rollback();
			return false;
		}
	}
}