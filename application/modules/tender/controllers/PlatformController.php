<?php
/**
 * file: PlatformController.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-24
 * desc: 支付平台选择
 */
class PlatformController extends Controller{
	
	public function actionIndex(){
		$userManager = Yii::app()->getModule('user')->userManager;
		
		$meta = BidMeta::model()->with('user','bid')->findByPk($this->getQuery('meta_no',1));
		$user = $meta->getRelated('user');
		$bid = $meta->getRelated('bid');
		$bider = $userManager->getUserInfo($bid->getAttribute('user_id'));
		
		if($user->getAttribute('id') == $this->user->getId()){
			$this->render('index',array(
				'user' => $user,
				'bid' => $bid,
				'bider' => $bider,
				'meta' => $meta,
			));
		}else{
			// 404
		}
	}
	
	public function actionProcess(){
		$payment = $this->getPost('payment','ips');
		$in_pay = $this->getPost('in-pay',0);

		$userManager = Yii::app()->getModule('user')->userManager;
		
		$meta = BidMeta::model()->with('user','bid')->findByPk($this->getQuery('meta_no'));
		$user = $meta->getRelated('user');
		$bid = $meta->getRelated('bid');
		$bider = $userManager->getUserInfo($bid->getAttribute('user_id'));
		
		if($in_pay != 0) $in_pay = $user->getAttribute('balance') / 100;
		
		if($user->getAttribute('id') == $this->user->getId()){
			if($in_pay - $meta->getAttribute('sum') / 100 >= 0){ // 账户余额付款
				$this->render('check',array(
					'user' => $meta->getRelated('user'),
					'bid' => $bid,
					'bider' => $bider,
					'meta' => $meta
				));
			}else{
				$this->render('process',array(
					'action' => Yii::app()->getModule('pay')->fundManager->pay($payment,$meta->getAttribute('id')),
					'sum' => $meta->getAttribute('sum') / 100 - $in_pay,
				));
			}
		}else{
			// 404
		}
	}
	
	public function actionBill(){
		$userManager = Yii::app()->getModule('user')->userManager;
		
		$this->render('bill',array(
			'user' => $userManager->getUserInfo(Yii::app()->user->getId()),
		));
	}
	
	public function actionCheck(){
		$password = $this->getPost('pay_pwd');
		$verify = $this->getPost('pay_verify');
		
		//$userManager = Yii::app()->getModule('user')->userManager;
		
		$meta = BidMeta::model()->with('user','bid')->findByPk($this->getQuery('meta_no'));
		$user = $meta->getRelated('user');
		//$bid = $meta->getRelated('bid');
		//$bider = $userManager->getUserInfo($bid->getAttribute('user_id'));
		
		if($user->getAttribute('id') == $this->user->getId()){
			if($this->getModule()->bidManager->payPurchaseBid($this->getQuery('meta_no'))){
				$this->render('success');
			}else{
				//$this->render();//失败
			}
		}else{
			// 404
		}
	}
}