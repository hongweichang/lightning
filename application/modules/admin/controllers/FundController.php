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
	}
	
	public function actionSite(){
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
}