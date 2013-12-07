<?php
/**
 * file: PayController.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-28
 * desc: 
 */
class PayController extends Controller{
	public function actionIndex(){
		$this->render('/public/entry',array(
			'tab' => array(
				array('待审核提现',$this->createUrl('')),
				array('审核未通过',$this->createUrl('')),
				array('提现列表',$this->createUrl('')),
				array('充值列表',$this->createUrl('pay/recharge')),
			)
		));
	}
	
	public function actionRecharge(){
		$fund = Yii::app()->getModule('pay')->fundManager;
		
		$fund->getListPay();
		
		$this->render('');
	}
}