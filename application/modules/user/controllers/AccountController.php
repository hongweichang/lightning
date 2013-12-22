<?php
/**
 * @name AccountController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-23 
 * Encoding UTF-8
 */
class AccountController extends Controller{
	public $layout='//layouts/login';
	
	public function noneLoginRequired(){
		return 'register,login,registerVerify,loginTransit';
	}
	
	public function actionLoginTransit(){
		$redirect = $this->getQuery('redirect',null);
		if ( $redirect === null ){
			$redirect = $this->request->urlReferrer;
		}
		
		$this->redirect($this->createUrl('account/login',array('redirect'=>urlencode($redirect))));
	}
	
	public function actionRegister(){
		if ( $this->user->getIsGuest() === false ){
			$this->redirect($this->createUrl('/site'));
		}
		
		$post = $this->getPost('Register');
		$userManager = $this->getModule()->getComponent('userManager');
		
		$form = $userManager->register($post);
		
		if ( $form === true ){
			$userManager->login(array(
					'account' => $post['email'],
					'password' => $post['password'],
					'rememberMe' => 'on'
			));
			$this->redirect($this->createUrl('/site'));
		}
		
		$this->render('layout',array(
			'model' => $form,
			'isLogin' => false,
			'form' => 'register',
		));
	}
	
	public function actionLogin(){
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('/site')));
		if ( $this->user->getIsGuest() === false ){
			$this->redirect($redirect);
		}
		
		$post = $this->getPost('Login');
		$userManager = $this->getModule()->getComponent('userManager');
		
		$form = $userManager->login($post);
		if ( $form === true ){
			//$this->redirect($this->createUrl('/site'));
			$this->redirect($redirect);
		}
		
		$this->render('layout',array(
				'model' => $form,
				'isLogin' => true,
				'form' => 'login',
				'redirect' => urlencode($redirect)
		));
	}
	
	public function actionLogout(){
		Yii::app()->user->logout();
		$this->redirect($this->createUrl('/site'));
	}
	
	public function actionRegisterVerify(){
		$mobile = $this->getQuery('mobile');
		if ( $mobile === null ){
			$this->response(404);
		}else {
			echo $mobile;die;
		}
	}
}