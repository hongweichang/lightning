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
		return 'register,login,registerVerify';
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
			'form' => 'register'
		));
	}
	
	public function actionLogin(){
		if ( $this->user->getIsGuest() === false ){
			$this->redirect($this->createUrl('/site'));
		}
		
		$post = $this->getPost('Login');
		$userManager = $this->getModule()->getComponent('userManager');
		
		$form = $userManager->login($post);
		if ( $form === true ){
			$this->redirect($this->createUrl('/site'));
		}
		
		$this->render('layout',array(
				'model' => $form,
				'isLogin' => true,
				'form' => 'login'
		));
	}
	
	public function actionLogout(){
		Yii::app()->user->logout();
		$this->redirect($this->createUrl('account/login'));
	}
	
	public function actionRegisterVerify(){
		$mobile = $this->getQuery('mobile');
		if ( $mobile === null ){
			$this->response(404);
		}else {
		}
	}
}
