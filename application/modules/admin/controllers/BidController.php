<?php
/**
 * file: BidController.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-14
 * desc: 
 */
class BidController extends Admin{
	public function init(){
		parent::init();
		
		$this->app->getModule('tender');
	}
	
	public function actionBidding(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('verify_progress=1');
		
		$selector = Selector::load('BidSeletor',$this->getQuery('BidSeletor'),$criteria);
		
		$dataProvider = new CActiveDataProvider('BidInfo',array(
				'criteria' => $criteria,
				'countCriteria' => array(
						'condition' => $criteria->condition,
						'params' => $criteria->params
				),
				'pagination' => array(
						'pageSize' => 20
				),
		));
		$this->tabTitle = '正在招标';
		$this->addNotifications('搜索','information',true);
		$this->render('view',array(
				'dataProvider' => $dataProvider,
				'selector' => $selector
		));
	}
	
	public function actionRepaying(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('verify_progress=2');
		
		$selector = Selector::load('BidSeletor',$this->getQuery('BidSeletor'),$criteria);
		
		$dataProvider = new CActiveDataProvider('BidInfo',array(
				'criteria' => $criteria,
				'countCriteria' => array(
						'condition' => $criteria->condition,
						'params' => $criteria->params
				),
				'pagination' => array(
						'pageSize' => 20
				),
		));
		$this->tabTitle = '正在还款';
		$this->addNotifications('搜索','information',true);
		$this->render('view',array(
				'dataProvider' => $dataProvider,
				'selector' => $selector
		));
	}
	
	public function actionDone(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('verify_progress=3');
		
		$selector = Selector::load('BidSeletor',$this->getQuery('BidSeletor'),$criteria);
		
		$dataProvider = new CActiveDataProvider('BidInfo',array(
				'criteria' => $criteria,
				'countCriteria' => array(
						'condition' => $criteria->condition,
						'params' => $criteria->params
				),
				'pagination' => array(
						'pageSize' => 20
				),
		));
		$this->tabTitle = '已完成';
		$this->addNotifications('搜索','information',true);
		$this->render('view',array(
				'dataProvider' => $dataProvider,
				'selector' => $selector
		));
	}
	
	public function actionLose(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('verify_progress=4');
		
		$selector = Selector::load('BidSeletor',$this->getQuery('BidSeletor'),$criteria);
		
		$dataProvider = new CActiveDataProvider('BidInfo',array(
				'criteria' => $criteria,
				'countCriteria' => array(
						'condition' => $criteria->condition,
						'params' => $criteria->params
				),
				'pagination' => array(
						'pageSize' => 20
				),
		));
		$this->tabTitle = '流标';
		$this->addNotifications('搜索','information',true);
		$this->render('view',array(
				'dataProvider' => $dataProvider,
				'selector' => $selector
		));
	}
}