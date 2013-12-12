<?php
/**
 * file: RechargeController.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-12
 * desc: 
 */
class RechargeController extends Admin{
	
	private $fund;
	
	public function init(){
		parent::init();
		
		$this->fund = Yii::app()->getModule('pay')->fundManager;
	}
	
	public function actionWaitting(){
		$pager = new CPagination(Withdraw::model()->count());
		$pager->setPageSize(20);
		
		$rawData = $this->fund->getWithdrawList(array(
			'offset' => $pager->getOffset(),
			'limit' => $pager->getLimit(),
			'order' => 'raise_time desc, finish_time desc',
			'condition' => 'status=0',
		));
		
		$this->render('waitting',array(
			'data' => new CArrayDataProvider($rawData),
			'pager' => $pager
		));
	}
	
	public function actionVerifyFailed(){
		$pager = new CPagination(Withdraw::model()->count());
		$pager->setPageSize(20);
	
		$rawData = $this->fund->getWithdrawList(array(
				'offset' => $pager->getOffset(),
				'limit' => $pager->getLimit(),
				'order' => 'raise_time desc, finish_time desc',
				'condition' => 'status=2',
		));
	
		$this->render('waitting',array(
				'data' => new CArrayDataProvider($rawData),
				'pager' => $pager
		));
	}
	
	public function actionWithdraw(){
		$pager = new CPagination(Withdraw::model()->count());
		$pager->setPageSize(20);
		
		$rawData = $this->fund->getWithdrawList(array(
				'offset' => $pager->getOffset(),
				'limit' => $pager->getLimit(),
				'order' => 'raise_time desc, finish_time desc',
		));
		
		$this->render('waitting',array(
				'data' => new CArrayDataProvider($rawData),
				'pager' => $pager
		));
	}

}