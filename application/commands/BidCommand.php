<?php
/**
 * file: BidCommand.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-24
 * desc: 标段状态处理
 */
class BidCommand extends CConsoleCommand{
	
	public function actionListen(){
		$db = Yii::app()->getModule('tender')->bidManager;
		$bids = $db->getBidList(array(
			'condition' => 'verify_progress=:s and progress!=:p and end<=:e',
			'params' => array(
				's' => 21,
				'p' => 100,
				'e' => time()
			)
		));
		
		$transaction = Yii::app()->db->beginTransaction();
		try{
			foreach($bids as $bid){
				$metas = $db->getBidMetaList(array(
					'condition' => 'bid_id='.$bid->getAttribute('id'),
				));
				
				foreach($metas as $meta){
					if($meta->getAttribute('status') == 21){
						$meta->getRelated('user')->saveCounters(array(
							'balance' => $meta->getAttribute('sum')
						));
					}
					$meta->attributes = array(
						'finish_time' => time(),
						'status' => 30 // 订单关闭
					);
					$meta->save();
				}
				
				$bid->attributes = array(
					'verify_progress' => 30 // 流标
				);
				$bid->save();
			}
			
			$transaction->commit();
			return true;
		}catch(Exception $e){
			$transaction->rollback();
			return false;
		}
	}
	
	public function actionRepay(){
		
	}
}