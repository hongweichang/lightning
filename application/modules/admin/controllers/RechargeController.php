<?php
/**
 * file: RechargeController.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-12
 * desc: 
 */
class RechargeController extends Admin{
	public function init(){
		parent::init();
		$this->app->getModule('pay');
	}
	
	public function actionWaitting(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('status=0');
		
		$selector = Selector::load('RechargeSelector',$this->getQuery('RechargeSelector'),$criteria);
		
		$dataProvider = new CActiveDataProvider('Withdraw',array(
			'criteria' => $criteria,
			'countCriteria' => array(
				'condition' => $criteria->condition,
				'params' => $criteria->params
			),
			'pagination' => array(
				'pageSize' => 20
			),
		));
		$this->tabTitle = '提现审核列表';
		$this->addNotifications('搜索','information',true);
		$this->render('waitting',array(
			'dataProvider' => $dataProvider,
			'selector' => $selector
		));
	}
	
	public function actionVerifyFailed(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('status=1');
		
		$selector = Selector::load('RechargeSelector',$this->getQuery('RechargeSelector'),$criteria);
		
		$dataProvider = new CActiveDataProvider('Withdraw',array(
			'criteria' => $criteria,
			'countCriteria' => array(
				'condition' => $criteria->condition,
				'params' => $criteria->params
			),
			'pagination' => array(
				'pageSize' => 20
			),
		));
		$this->tabTitle = '提现未成功列表';
		$this->addNotifications('搜索','information',true);
		$this->render('waitting',array(
			'dataProvider' => $dataProvider,
			'selector' => $selector
		));
	}
	
	public function actionWithdraw(){
		$criteria = new CDbCriteria();
		//$criteria->addCondition('status=0');
		
		$selector = Selector::load('RechargeSelector',$this->getQuery('RechargeSelector'),$criteria);
		
		$dataProvider = new CActiveDataProvider('Withdraw',array(
			'criteria' => $criteria,
			'countCriteria' => array(
				'condition' => $criteria->condition,
				'params' => $criteria->params
			),
			'pagination' => array(
				'pageSize' => 20
			),
		));
		$this->tabTitle = '提现列表';
		$this->addNotifications('搜索','information',true);
		$this->render('waitting',array(
			'dataProvider' => $dataProvider,
			'selector' => $selector
		));
	}
	
	public function actionView(){
		$criteria = new CDbCriteria();
		//$criteria->addCondition('status=0');
		
		$selector = Selector::load('RechargeSelector',$this->getQuery('RechargeSelector'),$criteria);
		
		$dataProvider = new CActiveDataProvider('Recharge',array(
				'criteria' => $criteria,
				'countCriteria' => array(
						'condition' => $criteria->condition,
						'params' => $criteria->params
				),
				'pagination' => array(
						'pageSize' => 20
				),
		));
		$this->tabTitle = '充值列表';
		$this->addNotifications('搜索','information',true);
		$this->render('waitting',array(
				'dataProvider' => $dataProvider,
				'selector' => $selector
		));
	}

}