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
	 * @param float $charge
	 * @param float $fee
	 * @return Ambigous <mixed, NULL, multitype:NULL >|boolean
	 */
	protected function raiseOrder($charge,$fee){
		$db = new Recharge();
		$db->attributes = array(
			'user_id' => $this->user->getState('id'),
			'sum' => $charge * 100,
			'fee' => round($fee * 100),
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
	 * 收到支付宝通知，执行站内支付业务逻辑
	 * @param string $trade_no
	 * @param array $post
	 * @return boolean
	 */
	protected function beginPay($trade_no){
		$record = Recharge::model()->findByPk($trade_no);
		if($record->getAttribute('status') >= 1) return false;
		
		$record->attribute = array(
			'platform' => $this->platform,
			'trade_no' => $this->trade_no,
			'subject' => $this->subject,
			'buyer' => $this->buyer,
			'buyer_id' => $this->buyer_id,
			'pay_time' => time(),
			'status' => 1
		);
		if($record->save()){
			FrontUser::model()->updateByPk($trade_no, array(
			));
			//业务逻辑
		}else{
	
		}
	}
	
	/**
	 * 收到支付宝通知，完成一个支付订单
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
		if($record->save()){
			//业务逻辑
		}else{
			
		}
	}
	
	/**
	 * 提交一个提现申请，等待后台处理
	 * @param float $charge
	 * @param float $fee
	 * @return boolean
	 */
	public function beginWithdraw($charge,$fee){
		$db = new Withdraw();
		$db->attributes = array(
			'user_id' => $this->user->getState('id'),
			'sum' => $charge * 100,
			'fee' => round($fee * 100),
			'raise_time' => time(),
			'status' => 0, // 正在处理 - 等待后台处理
		);
	
		return $db->save();
	}
	
	/**
	 * 后台处理提现申请
	 * @param string $trade_no
	 * @return boolean
	 */
	public function afterWithdraw($trade_no){
		$record = Withdraw::model()->findByPk($trade_no);
	
		$record->attributes = array(
			'finish_time' => time(),
			'status' => 1,
		);
	
		return $record->save();
	}
}