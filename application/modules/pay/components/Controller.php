<?php
/**
 * file: Controller.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-16
 * desc: 支付基础模块
 */
class Controller extends CmsController{
	
	/**
	 * 发起一个充值订单，并生成订单号
	 * @param float $charge
	 * @param float $fee
	 * @return Ambigous <mixed, NULL, multitype:NULL >|boolean
	 */
	protected function raiseOrder($charge,$fee){
		$db = new Recharge();
		$db->attributes = array(
			'user_id' => Yii::app()->user->getState('id'),
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
	protected function beginPay($trade_no,$post = array()){
		$post['pay_time'] = time();
		$post['status'] = 1;
		$record = Recharge::model()->findByPk($trade_no);
		if($record->getAttribute('status') >= $post['status']) return false;
		
		$record->attribute = $post;
		if($record->save()){
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
	protected function afterPay($trade_no,$post = array()){
		$post['finish_time'] = time();
		$post['status'] = 2;
		$record = Recharge::model()->findByPk($trade_no);
		if($record->getAttribute('status') >= $post['status']) return false;
		
		$record->attribute = $post;
		if($record->save()){
			//业务逻辑
		}else{
			
		}
	}
	
	protected function errorPay($id){
		//
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
			'user_id' => Yii::app()->user->getState('id'),
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