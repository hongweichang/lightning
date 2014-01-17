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
		
		$criteria->with = array('user');
		$selector = Selector::load('RechargeSelector',$this->getQuery('RechargeSelector'),$criteria);
		
		$criteria->order = 'raise_time asc';
		$dataProvider = new CActiveDataProvider('Withdraw',array(
			'criteria' => $criteria,
			'countCriteria' => array(
				'with' => $criteria->with,
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
	
	public function actionPass(){
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('recharge/waitting')));
		$id = $this->getQuery('id',null);
		$fund = Yii::app()->getModule('pay')->fundManager;
		
		$result = $fund->handleWithdraw($id);
		if ( $result ){
			$this->showMessage('提现处理完成',$redirect,false);
		}else {
			$this->showMessage('提现处理失败，管理员不存在',$redirect,false);
		}
	}
	
	public function actionNpass(){
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('recharge/waitting')));
		$id = $this->getQuery('id',null);
		$fund = Yii::app()->getModule('pay')->fundManager;
		
		$result = $fund->revokeWithdraw($id);
		if ( $result ){
			$this->showMessage('提现撤销完成',$redirect,false);
		}else {
			$this->showMessage('提现撤销失败，管理员不存在',$redirect,false);
		}
	}
	
	public function actionVerifyFailed(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('status=2');
		$criteria->with = array('user');
		$selector = Selector::load('RechargeSelector',$this->getQuery('RechargeSelector'),$criteria);
		
		$criteria->order = 'finish_time desc,raise_time desc';
		$dataProvider = new CActiveDataProvider('Withdraw',array(
			'criteria' => $criteria,
			'countCriteria' => array(
				'with' => $criteria->with,
				'condition' => $criteria->condition,
				'params' => $criteria->params
			),
			'pagination' => array(
				'pageSize' => 20
			),
		));
		$this->tabTitle = '提现未成功列表';
		$this->addNotifications('搜索','information',true);
		$this->render('verifyFailed',array(
			'dataProvider' => $dataProvider,
			'selector' => $selector
		));
	}
	
	public function actionWithdraw(){
		$criteria = new CDbCriteria();
		//$criteria->addCondition('status=0');
		
		$criteria->with = array('user');
		$selector = Selector::load('RechargeSelector',$this->getQuery('RechargeSelector'),$criteria);
		
		$criteria->order = 'finish_time desc,raise_time desc';
		$dataProvider = new CActiveDataProvider('Withdraw',array(
			'criteria' => $criteria,
			'countCriteria' => array(
				'with' => $criteria->with,
				'condition' => $criteria->condition,
				'params' => $criteria->params
			),
			'pagination' => array(
				'pageSize' => 20
			),
		));
		$this->tabTitle = '提现列表';
		$this->addToSubTab('导出提现记录','excelOutput/withDraw');
		$this->addNotifications('搜索','information',true);
		$this->render('withdraw',array(
			'dataProvider' => $dataProvider,
			'selector' => $selector
		));
	}
	
	public function actionView(){
		$criteria = new CDbCriteria();
		//$criteria->addCondition('status=0');
		$criteria->with = array('user');
		$selector = Selector::load('RechargeSelector',$this->getQuery('RechargeSelector'),$criteria);
		
		$criteria->order = 'finish_time desc,pay_time desc';
		$dataProvider = new CActiveDataProvider('Recharge',array(
				'criteria' => $criteria,
				'countCriteria' => array(
						'with' => $criteria->with,
						'condition' => $criteria->condition,
						'params' => $criteria->params
				),
				'pagination' => array(
						'pageSize' => 20
				),
		));
		$this->tabTitle = '充值列表';
		$this->addNotifications('搜索','information',true);
		$this->render('view',array(
				'dataProvider' => $dataProvider,
				'selector' => $selector
		));
	}

}