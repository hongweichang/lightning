<?php
/**
 * file: FundManager.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-27
 * desc: 
 */
class FundManager extends CApplicationComponent{
	/**
	 * 跳转地址，进入支付阶段
	 */
	public function pay($payment,$param = array()){
		return Yii::app()->createUrl('pay/'.$payment.'/index',$param);
	}
	
	/**
	 * 提交一个提现申请，等待后台处理
	 * @param float $charge
	 * @param float $fee
	 * @return boolean
	 */
	public function raiseWithdraw($uid,$sum,$charge){
		$user = Yii::app()->getModule('user')->userManager->findByPk($uid);
		
		$transaction = Yii::app()->db->beginTransaction();
		try{
			$user->updateCounters(array(
				'balance' => -($sum + charge) * 100
			));
			
			$db = new Withdraw();
			$db->attributes = array(
				'user_id' => $uid,
				'sum' => $sum * 100,
				'fee' => $charge * 100,
				'raise_time' => time(),
				'status' => 0, // 正在处理 - 等待后台处理
			);
			$db->save();
			
			$transaction->commit();
			return true;
		}catch (Exception $e){
			$transaction->rollback();
			return false;
		}
	}
	
	/**
	 * 后台处理提现申请
	 * @param string $trade_no
	 * @return boolean
	 */
	public function handleWithdraw($trade_no){
		$record = Withdraw::model()->findByPk($trade_no);
		if($record->getAttribute('status') >= 1) return false;
		
		$record->attributes = array(
			'finish_time' => time(),
			'status' => 1,
		);
	
		return $record->save();
	}
	
	/**
	 * 后台撤销提现申请
	 * @param string $trade_no
	 * @return boolean
	 */
	public function revokeWithdraw($trade_no){
		$record = Withdraw::model()->findByPk($trade_no);
		$user = Yii::app()->getModule('user')->userManager->getUserInfo($record->getAttribute('user_id'));
		
		$transaction = Yii::app()->db->beginTransaction();
		try{
			$user->updateCounters(array(
				'balance' => $record->getAttribute('sum') + $record->getAttribute('fee')
			));
			
			$record->attributes = array(
				'finish_time' => time(),
				'status' => 2,
			);
			$record->save();
			$transaction->commit();
			return true;
		}catch (Exception $e){
			$transaction->rollback();
			return false;
		}
	}
	
	/**
	 * 站内点对点资金流动记录
	 * @param int $fromuid 资金来源
	 * @param int $touid 资金去向
	 * @param double $charge 资金
	 * @param double $fee 手续费
	 * @return boolean
	 */
	public function p2p($touid,$fromuid,$sum,$charge,$status = 0){
		$db = new FundFlowInternal();
		$db->attributes = array(
			'to_user' => $touid,
			'from_user' => $fromuid,
			'sum' => $sum * 100,
			'fee' => $charge * 100, // 四舍五入??
			'time' => time(),
			'status' => $status
		);
		return $db->save();
	}
	
	public function getP2pList($condition,$params = array()){
		return FundFlowInternal::model()->with('toUser')->findAll($condition,$params);
	}

	/**
	 * 
	 * @param unknown $status
	 * @return array()
	 */
	public function getWithdrawList($condition,$params = array()){
		return Withdraw::model()->with('user')->findAll($condition,$params);
	}
	
	public function getPayList($condition,$params = array()){
		return Recharge::model()->with('user')->findAll($condition,$params);
	}
}