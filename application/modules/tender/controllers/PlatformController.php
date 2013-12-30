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
		
		if ( $meta !== null && $meta->status != 11 ){
			$meta = null;
		}
		
		if( !empty($meta) && $meta->getAttribute('user_id') == $this->user->getId() ){
			$user = $meta->getRelated('user');
			$bid = $meta->getRelated('bid');
			
			$this->setPageTitle($bid->getAttribute('title').' - '.$this->name);
			
			$userManager = Yii::app()->getModule('user')->userManager;
			$bider = $userManager->getUserInfo($bid->getAttribute('user_id'));
			
			$errorMsg = $this->getQuery('e',null);
			if( !empty($_POST) ){
				$payment = $this->getPost('payment','ips');
				$in_pay = $this->getPost('in-pay','off');
				$check = $user->getAttribute('balance') >= $meta->getAttribute('sum');
				
				if($in_pay == 'on' && $check === true ){
					$this->render('check',array(
						'user' => $user,
						'bid' => $bid,
						'bider' => $bider,
						'meta' => $meta,
						'errorMsg' => null
					));
					$this->app->end();
				}else{
					$this->redirect(Yii::app()->getModule('pay')->fundManager->pay(
						$payment,
						Utils::appendEncrypt($meta->getAttribute('id')),
						$in_pay
					));
				}
			}elseif ( !empty($errorMsg) ){
				$this->render('check',array(
						'user' => $user,
						'bid' => $bid,
						'bider' => $bider,
						'meta' => $meta,
						'errorMsg' => base64_decode($errorMsg)
				));
				$this->app->end();
			}
			
			$this->render('index',array(
				'user' => $user,
				'bid' => $bid,
				'bider' => $bider,
				'meta' => $meta,
				'errorMsg' => $errorMsg
			));
		}else{
			//404
		}
	}
	
	public function actionCheck(){
		$metaId = Utils::appendDecrypt($this->getQuery('metano'));
		$meta = BidMeta::model()->with('user','bid')->findByPk($metaId);
		
		if ( $meta !== null && $meta->status != 11 ){
			$meta = null;
		}
		
		if( $meta !== null && $meta->getAttribute('user_id') == $this->user->getId()){
			$this->setPageTitle($meta->getRelated('bid')->getAttribute('title').' - '.$this->name);
			
			$password = $this->getPost('pay_pwd');
			$code = $this->getPost('pay_verify');
			$user = $meta->getRelated('user');
			$notify = $this->app->getModule('notify')->getComponent('notifyManager');
			
			if ( $this->app->getSecurityManager()->verifyPassword($password,$user->pay_password) === false ){
				$notify->clearMobileVerifyCode($user->mobile);
				
				$this->redirect($this->createUrl('platform/order',array(
						'metano' => Utils::appendEncrypt($metaId),
						'e' => base64_encode('1支付密码错误')
				)));
			}
			

			if ( $notify->applyMobileCodeVerify($user->mobile,$code) === false ){
				$this->redirect($this->createUrl('platform/order',array(
						'metano' => Utils::appendEncrypt($metaId),
						'e' => base64_encode('2验证码错误')
				)));
			}
			
			$notify->clearMobileVerifyCode($user->mobile);
			$asyncEventRunner = Yii::app()->getComponent('asyncEventRunner');
			$asyncEventRunner->zmqClientId = 'zmqPurchaseClient';
			$asyncEventRunner->raiseAsyncEvent('onPayPurchasedBid',array(
				'metano' => $metaId
			));
			
			$this->render('success');
		}else{
			// 404
		}
	}
	
	public function actionSendVerify(){
		$mobile = $this->getQuery('mobile');
		if ( $mobile === null ){
			$this->response(404);
		}
		
		$asyncEventRunner = $this->app->getComponent('asyncEventRunner');
		$asyncEventRunner->raiseAsyncEvent('onBeforePayBidSuccess',array(
				'mobile' => $mobile
		));
	}
}