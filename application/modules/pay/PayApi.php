<?php
/**
 * file: PayApi.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-20
 * desc: 支付模块接口
 */
class PayApi{
	
	public static function pay(){
		return Yii::app()->createUrl("pay/platform/index");
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
	
	/**
	 * 站内点对点资金流动
	 * @param int $fromuid 资金来源
	 * @param int $touid 资金去向
	 * @param double $charge 资金
	 * @param double $fee 手续费
	 * @return boolean
	 */
	public static function p2p($fromuid,$touid,$charge,$fee){
		$db = new FundFlowInternal();
		$db->attributes = array(
			'to_user' => $touid,
			'from_user' => $fromuid,
			'sum' => $charge * 100,
			'fee' => round($fee * 100), // 四舍五入??
			'time' => time(),
			'status' => 1 // 暂时不分过程
		);
		
		return $db->save();
	}
}