<?php
/**
 * @name AccountController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-23 
 * Encoding UTF-8
 */
class AccountController extends Controller{
	public function filters(){
		return array();
	}
	
	public function actions(){
		return array(
				'captcha'=>array(
						'class'=>'CCaptchaAction',
						'backColor'=>0xFFFFFF,
						'maxLength' => 4,
						'minLength' => 4
				),
		);
	}
	
	public function actionRegister(){
		$post = $this->getPost();
		$userManager = $this->getModule()->getComponent('userManager');
		
		if ( $post !== array() ){
			$regInfo = array(
				'nickname' => $post['signup_nickname'],
				'email' => $post['signup_email'],
				'mobile' => $post['signup_phone'],
				'password' => $post['signup_password'],
				'confirm' => $post['signup_password_confirm'],
				'code' => $post['signup_verifycode'],
			);
		}else {
			$regInfo = array();
		}
		$form = $userManager->register($regInfo);
		
		if ( $form === true ){
			$this->redirect($this->createUrl('userInfo/infoAdd'));
		}
		
		$this->render('layout',array(
			'model' => $form,
			'isLogin' => false
		));
	}
	
	public function actionLogin(){
		$form = new LoginForm();
		if($this->getPost('username') && $this->getPost('password')){
			$form->attributes = array(
					'username' => $this->getPost('username'),
					'password' => $this->getPost('password'),
					'keey' => $this->getPost('keepSignIn')
			);
			if($form->validate() && $form->login()){
		
			}
		}
		
		$this->render('layout',array(
				'model' => $form,
				'isLogin' => true
		));
	}
	
	public function actionLogout(){
		Yii::app()->user->logout();
		$this->redirect($this->app->getHomeUrl());
	}
}