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
		$this->tabTitle = '正在招标';
		$this->process(1);
	}
	
	public function actionRepaying(){
		$this->tabTitle = '正在还款';
		$this->process(2);
	}
	
	public function actionDone(){
		$this->tabTitle = '已完成';
		$this->process(3);
	}
	
	public function actionLose(){
		$this->tabTitle = '流标';
		$this->process(4);
	}
	
	protected function process($progress){
		$criteria = new CDbCriteria();
		$criteria->addCondition('verify_progress=:progress');
		$criteria->params[':progress'] = $progress;
		
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
		
		$this->addNotifications('搜索','information',true);
		$this->render('view',array(
				'dataProvider' => $dataProvider,
				'selector' => $selector
		));
	}
}