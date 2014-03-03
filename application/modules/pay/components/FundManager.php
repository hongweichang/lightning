<?php
/**
 * file: FundManager.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-27
 * desc: 
 */
class FundManager extends CApplicationComponent{
	/**
	 * 跳转地址，进入支付阶段 metaId & inpay or sum
	 */
	public function pay($payment,$metano,$inpay = null){
		$bid = Yii::app()->getModule('tender')->bidManager;
		$credit = Yii::app()->getModule('credit')->userCreditManager;
		$rate = $credit->userRateGet(Yii::app()->user->getId());
		if(empty($inpay)){
			$key = $this->raisePayOrder($payment,$metano, $metano * $rate['on_recharge']);
		}else{
			$key = 0;
			$meta = $bid->getBidMetaInfo($metano);
			if($inpay == 'on'){
				$sum = ($meta->getAttribute('sum') - $meta->getRelated('user')->getAttribute('balance')) / 100;	
				if($sum > 0){
					$key = $this->raisePayOrder($payment,$sum, $sum * $rate['on_recharge'],$meta->getAttribute('id'));
				}
			}else{
				$sum = $meta->getAttribute('sum') / 100;
				$key = $this->raisePayOrder($payment,$sum, $sum * $rate['on_recharge'],$meta->getAttribute('id'));
			}
		}
		
		return Yii::app()->createUrl('pay/'.$payment.'/order',array(
			'key'=> Utils::appendEncrypt($key)
		));
	}
	
	/**
	 * 发起一个充值订单，并生成订单号
	 * @param float $sum
	 * @param float $charge
	 * @return integer|boolean
	 */
	protected function raisePayOrder($payment,$sum,$charge,$meta = 0){
		$db = new Recharge();
		$db->attributes = array(
			'user_id' => Yii::app()->user->getId(),
			'meta_id' => $meta,
			'sum' => $sum * 100,
			'fee' => $charge * 100,
			'platform' => $payment,
			'raise_time' => time(),
			'status' => 0,
		);
		if($db->save()){
			return $db->getPrimaryKey();
		}else{
			return 0;
		}
	}
	
	/**
	 * 提交一个提现申请，等待后台处理
	 * @param float $charge
	 * @param float $fee
	 * @return boolean
	 */
	public function raiseWithdraw($uid,$sum,$arg3 = null){
		$user = Yii::app()->getModule('user')->userManager->getUserInfo($uid);
		$credit = Yii::app()->getModule('credit')->userCreditManager;
		//费用计算
		$rate = $credit->userRateGet($uid);
		$fee = round($sum * $rate['on_withdraw'],2);
		
		$transaction = Yii::app()->db->beginTransaction();
		try{
			$user->saveCounters(array(
				'balance' => -100 * $sum
			));
			//$user->save();
			
			$db = new Withdraw();
			$db->attributes = array(
				'user_id' => $uid,
				'sum' => ($sum - $fee) * 100,
				'fee' => $fee * 100,
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
			$user->saveCounters(array(
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

	public function getWithdrawList($condition,$params = array()){
		return Withdraw::model()->with('user')->findAll($condition,$params);
	}
	
	public function getPayList($condition,$params = array()){
		return Recharge::model()->with('user')->findAll($condition,$params);
	}
}