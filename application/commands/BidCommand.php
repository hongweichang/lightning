<?php
/**
 * file: BidCommand.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-24
 * desc: 标段状态处理
 */
class BidCommand extends LightningCommandBase{
	/**
	 * 流标
	 */
	public function actionRevoke(){
		$db = Yii::app()->getModule('tender')->bidManager;
		$bids = $db->getBidList(array(
			'condition' => 'verify_progress=:s and progress!=:p and end<=:e',
			'params' => array(
				's' => 21,
				'p' => 100,
				'e' => time()
			)
		));
		
		foreach($bids as $bid){
			if($db->revokeBid($bid)){
				$asyncEvent = $this->app->getComponent('asyncEventRunner');
				$asyncEvent->raiseAsyncEvent('onRevokeBid',array(
					'bidId' => $bid->id
				));
			}
		}
	}
	
	/**
	 * 还款通知
	 */
	public function actionRepay(){
		$db = Yii::app()->getModule('tender')->bidManager;
		$bids = $db->getBidList(array(
			'condition' => 'verify_progress=31',
		));

		$date = mktime(0,0,0);
		$h31d = array(1,3,5,7,8,10,12);
		$h30d = array(4,6,9,11);
		
		$asyncEvent = $this->app->getComponent('asyncEventRunner');
		
		foreach($bids as $bid){
			$repay_time = strtotime(date('Y-n-j',$bid->getAttribute('repay_time')));
			list($year,$month,$day) = explode('-', date('Y-n-j',$date - $repay_time));

			$isSend = 0;
			if($bid->getAttribute('repay_deadline') + $month - 1 > $bid->getAttribute('deadline')){
				if($day >=3){
					$db->finishBid($bid,true); // 逾期
					$asyncEvent->raiseAsyncEvent('onRepayDelay',array(
							'bidId' => $bid->id
					));
				}else{
					$isSend = 3 - $day;
				}
			}else{
				if(in_array($month, $h31d) && $day >= 29){
					$isSend = 34 - $day;
				}else if(in_array($month, $h30d) && $day >= 28){
					$isSend = 33 - $day;
				}else if($month == 2 && $day >= 26){
					if($year % 4 == 0 && ($year % 100 != 0 || $year % 400 == 0)){
						if($day >= 27){
							$isSend = 32 - $day;
						}
					}else{
						$isSend = 31 - $day;
					}
				}
			}
			
			if( $isSend > 0 ){
				$asyncEvent->raiseAsyncEvent('onRepay',array(
						'bidId' => $bid->id,
						'dayLeft' => $isSend//剩余天数
				));
			}
		}
	}
	
	/**
	 * 标段付款
	 */
	public function actionPay($params = ''){
		$db = Yii::app()->getModule('tender')->bidManager;
		$db->payPurchasedBid($this->parameters['metano']);
	}
}