<?php
/**
 * file: BidCommand.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-24
 * desc: 标段状态处理
 */
class BidCommand extends CConsoleCommand{
	
	/**
	 * 流标监听
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
			$db->revokeBid($bid);
		}
	}
	
	/**
	 * 还款监听
	 */
	public function actionRepay(){
		$db = Yii::app()->getModule('tender')->bidManager;
		$bids = $db->getBidList(array(
			'condition' => 'verify_progress=31',
		));
		
		foreach($bids as $bid){
			$db->revokeBid($bid);
		}
	}
}