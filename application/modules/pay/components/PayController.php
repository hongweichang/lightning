<?php
/**
 * file: Controller.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-16
 * desc: 支付基础模块
 */
class PayController extends Controller{
	protected $platform; // 支付平台
	protected $trade_no; // 平台订单号
	protected $subject;	 // 订单名
	protected $buyer;	 // 平台账号
	protected $buyer_id; //	平台ID
	
	protected function getPayOrder(){
		$key = Utils::appendDecrypt($this->getQuery('key'));
		return Recharge::model()->findByPk($key);
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
			
			$user = Yii::app()->getModule('user')->userManager->findByPk(Yii::app()->user->getId());
			$user->saveCounters(array(
				'balance' => $record->getAttribute('sum')
			));
			
			$transaction->commit();
			
			if($record->getAttribute('meta_id') != 0){
				$asyncEventRunner = Yii::app()->getComponent('asyncEventRunner');
				$asyncEventRunner->raiseAsyncEvent('onPayPurchasedBid',array(
					'metano' => $record->getAttribute('meta_id')
				));
			}
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