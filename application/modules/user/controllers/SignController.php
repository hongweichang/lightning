<?php
/**
 * file: LoginController.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-18
 * desc: 注册模块
 */
class SignController extends Controller{

	public function filters(){
		return array();
	}
	
	public function actions(){
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}

	public function actionIndex(){
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
		
		$this->render('/login/index',array(
			'model' => $form,
			'isLogin' => false
		));
	}
}