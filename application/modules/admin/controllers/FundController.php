<?php
/**
 * file: FundController.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-14
 * desc: 
 */
class FundController extends Admin{
	public function init(){
		parent::init();
		$this->app->getModule('pay');
		$this->app->getModule('tender');
		$this->app->getModule('user');
	}
	
	public function actionInvestment(){
		$criteria = new CDbCriteria();
		//$criteria->addCondition('status=0');
		
		//$selector = Selector::load('RechargeSelector',$this->getQuery('RechargeSelector'),$criteria);
		
		$dataProvider = new CActiveDataProvider('FundFlowInternal',array(
				'criteria' => $criteria,
				'countCriteria' => array(
						'condition' => $criteria->condition,
						'params' => $criteria->params
				),
				'pagination' => array(
						'pageSize' => 20
				),
		));
		$this->tabTitle = '站内资金流动记录';
		//$this->addNotifications('搜索','information',true);
		$this->render('waitting',array(
				'dataProvider' => $dataProvider,
				//'selector' => $selector
		));
	}
	
	public function actionSite(){

		$this->render('site',array(
			'sum' => FrontUser::model()->sum('balance') / 100,
			'recharge' => Recharge::model()->sum('sum') / 100,
			'withdraw' => Withdraw::model()->sum('sum') / 100,
			'view' => BidInfo::model()->sum('sum','verify_progress=0') / 100,
			'biding' => BidInfo::model()->sum('sum','verify_progress=1') / 100,
			'repaying' => BidInfo::model()->sum('sum','verify_progress=3') / 100,
			'done' => BidInfo::model()->sum('sum','verify_progress=4') / 100,
			'lose' => BidInfo::model()->sum('sum','verify_progress=5') / 100,
		));
	}
}