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
		$tenderManager = Yii::app()->getModule('tender')->bidManager;

		$this->render('index',array(
			'user' => $userManager->getUserInfo($this->app->user->getId()),
			'tender' => $tenderManager->getBidInfo($this->request->getPost('bidid',1)),
			'sum' => $this->request->getPost('money',1000)
		));
	}
	
	public function actionBill(){
		$userManager = Yii::app()->getModule('user')->userManager;
		
		$this->render('bill',array(
			'user' => $userManager->getUserInfo(Yii::app()->user->getId()),
		));
	}
}