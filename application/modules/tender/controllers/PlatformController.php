<?php
/**
 * file: PlatformController.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-24
 * desc: 支付平台选择
 */
class PlatformController extends Controller{
	private $name = '结算中心';
	
	public function actionOrder(){
		$metaId = Utils::appendDecrypt($this->getQuery('metano'));
		$meta = BidMeta::model()->with('user','bid')->findByPk($metaId);

		if(!empty($meta) && $meta->getAttribute('user_id') == $this->user->getId()){
			$user = $meta->getRelated('user');
			$bid = $meta->getRelated('bid');
			
			$this->setPageTitle($bid->getAttribute('title').' - '.$this->name);
			
			$userManager = Yii::app()->getModule('user')->userManager;
			$bider = $userManager->getUserInfo($bid->getAttribute('user_id'));
			
			if(!empty($_POST)){
				$payment = $this->getPost('payment','ips');
				$in_pay = $this->getPost('in-pay','off');
				
				if($in_pay == 'on' && $user->getAttribute('balance') >= $meta->getAttribute('sum')){
					$this->render('check',array(
						'user' => $user,
						'bid' => $bid,
						'bider' => $bider,
						'meta' => $meta
					));
					$this->app->end();
				}else{
					$this->redirect(Yii::app()->getModule('pay')->fundManager->pay(
						$payment,
						Utils::appendEncrypt($meta->getAttribute('id')),
						$in_pay
					));
				}
			}
			
			$this->render('index',array(
				'user' => $user,
				'bid' => $bid,
				'bider' => $bider,
				'meta' => $meta,
			));
		}else{
			//404
		}
	}
	
	public function actionCheck(){
		$metaId = Utils::appendDecrypt($this->getQuery('metano'));
		$meta = BidMeta::model()->with('user','bid')->findByPk($metaId);

		if( $meta !== null && $meta->getAttribute('user_id') == $this->user->getId()){
			$this->setPageTitle($meta->getRelated('bid')->getAttribute('title').' - '.$this->name);
			
			$data = $this->getPost('Check');
			$password = $this->getPost('pay_pwd');
			$code = $this->getPost('pay_verify');
			$user = $meta->getRelated('user');
			
// 			if ( $this->app->getSecurityManager()->verifyPassword() === false ){
//
// 			}
			
			Yii::app()->getModule('tender')->bidManager->payPurchasedBid($metaId);
			//$asyncEventRunner = Yii::app()->getComponent('asyncEventRunner');
			//$asyncEventRunner->raiseAsyncEvent('onPayPurchasedBid',array(
			//	'metano' => $metaId
			//));
			
			$this->render('success');
		}else{
			// 404
		}
	}
}