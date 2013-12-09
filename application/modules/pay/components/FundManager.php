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
	public function pay($payment,$meta_id = null){
		if($meta_id == null){
			return Yii::app()->createUrl('pay/'.$payment.'/index');
		}else{
			return Yii::app()->createUrl('pay/'.$payment.'/index',array('meta_no' => $meta_id));
		}
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
		$user = Yii::app()->getModule('user')->userManager->findByPk($record->getAttribute('user_id'));
		
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
	public function p2p($touid,$fromuid,$sum,$charge){
		$db = new FundFlowInternal();
		$db->attributes = array(
			'to_user' => $touid,
			'from_user' => $fromuid,
			'sum' => $sum * 100,
			'fee' => $charge * 100, // 四舍五入??
			'time' => time(),
			'status' => 1 // 暂时不分过程
		);
		return $db->save();
	}
	
	public function calculate($sum){
		return $sum;
	}

	/**
	 * 
	 * @param unknown $status
	 * @return array()
	 */
	public function getWithdrawList($status){
		$pager = new CPagination(Withdraw::model()->count());
		$pager->setPageSize(20);
		
		$list = Withdraw::model()->with('user')->findAll(array(
			'offset' => $pager->getOffset(),
			'limit' => $pager->getLimit(),
			'order' => 'raise_time desc, finish_time desc',
			'condition' => 'status=:s',
			'param' => array('s' => $status)
		));
		
		return array('list' => $list, 'pager' => $pager);
	}
	
	public function getPayList($condition,$param){
		$pager = new CPagination(Recharge::model()->count());
		$pager->setPageSize(20);
		
		$list = Recharge::model()->with('user')->findAll(array(
			'offset' => $pager->getOffset(),
			'limit' => $pager->getLimit(),
			'order' => 'raise_time desc, pay_time desc, finish_time desc',
			'condition' => $condition,
			'param' => $param
		));
		
		return array('list' => $list, 'pager' => $pager);
	}
}