<?php
/**
 * file: PlatformController.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-24
 * desc: 支付平台选择
 */
class PlatformController extends Controller{
	//number_format(10000,2);
	public function actionIndex(){
		$userManager = Yii::app()->getModule('user')->userManager;
		
		$this->render('index',array(
			'mine' => $userManager->getUserInfo(Yii::app()->user->getId()),
		));
	}
	
	public function actionBill(){
		$userManager = Yii::app()->getModule('user')->userManager;
		$this->render('bill',array(
			'mine' => $userManager->getUserInfo(Yii::app()->user->getId()),
		));
	}
}