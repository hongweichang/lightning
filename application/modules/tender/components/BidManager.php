<?php
/**
 * @name BidManager.php
 * @author wxweven wxweven@163.com
 * Date 2013-11-27 
 * Encoding UTF-8
 */
class BidManager extends CApplicationComponent{	
	/**
	 * 根据标段的id,返回标段的详细信息
	 * Enter description here ...
	 * @param $bidId
	 * @return $bidDetail 标段的详细信息
	 */
	public function getBidInfo($bidId,$condition='',$params=array()) {
		return BidInfo::model()->with('user')->findByPk( $bidId ,$condition,$params); // 通过标段id来获取标段信息
	}
	
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
		$refund = $this->calculateRefund($sum, $rate / 1200, $deadline) * 100;
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
			'verify_progress' => 0,
			'refund'=>$refund
		);
		
		if($bid->save()){
			return $bid->getPrimaryKey();
		}else{
			var_dump($bid->getErrors());
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
			$bid = BidInfo::model()->findByPk($bid_id);
			if(empty($bid)) return false;
			$progress = ($sum * 10000) / $bid->getAttribute('sum');
			if($bid->getAttribute('progress') + $progress > 100) return false;
			$bid->saveCounters(array(
				'progress' => $progress  // 锁定进度
			));
			
			//改progress为已投资金
			/*if($bid->getAttribute('progress') + $sum * 100 > $bid->getAttribute('sum')) return false;
			$bid->saveCounters(array(
				'progress' => $sum * 100  // 锁定进度
			));*/
			
			$meta = new BidMeta();
			$meta->attributes = array(
				'user_id' => $user_id,
				'bid_id' => $bid_id,
				'sum' => $sum * 100,
				'refund' => $this->calculateRefund($sum, $bid->getAttribute('month_rate') / 1200, $bid->getAttribute('deadline')) * 100,
				'buy_time' => time(),
				'status' => 0 // 订单未支付
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
		$meta = BidMeta::model()->with('user','bid')->findByPk($meta_no);
		if(empty($meta) || $meta->getAttribute('status') >= 1) return false;
		$user = $meta->getRelated('user');
		
		$transaction = Yii::app()->db->beginTransaction();
		try{
			$user->saveCounters(array(
				'balance' => - $meta->getAttribute('sum')
			));
			
			$meta->attributes = array(
				'finish_time' => time(),
				'status' => 1 //订单已支付
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
		$meta = BidMeta::model()->with('user','bid')->findByPk($meta_no);
		if(empty($meta) || $meta->getAttribute('status') >= 1) return false;
		$user = $meta->getRelated('user');
		$bid = $meta->getRelated('bid');
		
		$transaction = Yii::app()->db->beginTransaction();
		try{
			$bid->saveCounters(array(
				'progress' => - $meta->getAttribute('sum') * 100 / $bid->getAttribute('sum')
			));
			
			//改progress为已投资金
			/*$bid->saveCounters(array(
				'progress' => - $meta->getAttribute('sum')
			));*/
		
			$meta->attributes = array(
				'finish_time' => time(),
				'status' => 2
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
	 * 后台审核Bid
	 * @param integer $bid
	 * @param string $message
	 */
	public function handleBid($bid,$message = null){
		if(empty($message)){
			return BidInfo::model()->updateByPk($bid,array('verify_progress' => 1));
		} else {
			return BidInfo::model()->updateByPk($bid,array(
				'verify_progress' => 2,
				'failed_description' => $message
			));
		}
	}
}