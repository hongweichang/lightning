<?php
/**
 * file: Controller.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-16
 * desc: 支付基础模块
 */
class PayController extends CmsController{
	protected $platform; // 支付平台
	protected $trade_no; // 平台订单号
	protected $subject;	 // 订单名
	protected $buyer;	 // 平台账号
	protected $buyer_id; //	平台ID
	
	/**
	 * 发起一个充值订单，并生成订单号
	 * @param float $sum
	 * @param float $charge
	 * @return Ambigous <mixed, NULL, multitype:NULL >|boolean
	 */
	protected function raiseOrder($sum,$charge){
		$db = new Recharge();
		$db->attributes = array(
			'user_id' => $this->user->getId(),
			'sum' => $sum * 100,
			'fee' => round($charge * 100),
			'raise_time' => time(),
			'status' => 0,
		);
		if($db->save()){
			return $db->getPrimaryKey();
		}else{
			return false;
		}
	}

	/**
	 * 收到通知，执行站内支付业务逻辑
	 * @param string $trade_no
	 * @param array $post
	 * @return boolean
	 */
	protected function beginPay($trade_no){
		$record = Recharge::model()->findByPk($trade_no);
		if($record->getAttribute('status') >= 1) return false;
		
		$transaction = Yii::app()->db->beginTransaction();
		try{
			$record->attribute = array(
				'platform' => $this->platform,
				'trade_no' => $this->trade_no,
				'subject' => $this->subject,
				'buyer' => $this->buyer,
				'buyer_id' => $this->buyer_id,
				'pay_time' => time(),
				'status' => 1
			);
			$record->save();
			Yii::app()->getModule('user')->userManager->updateBalance(
				Yii::app()->user->getId(),
				$record->getAttribute('sum')
			);
			$transaction->commit();
			return true;
		}catch (Exception $e){
			$transaction->rollback();
			return false;
		}
	}
	
	/**
	 * 收到通知，完成一个支付订单
	 * @param string $trade_no
	 * @param array $post
	 * @return boolean
	 */
	protected function afterPay($trade_no){
		$record = Recharge::model()->findByPk($trade_no);
		if($record->getAttribute('status') >= 2) return false;
		
		$record->attribute = array(
			'finish_time' => time(),
			'status' => 2
		);
		return $record->save();
	}
	
}