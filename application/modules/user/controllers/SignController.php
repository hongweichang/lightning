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
		$form = new RegisterForm();
		
		$post = $this->getPost();
		if(!empty($post)){
			$form->attributes = array(
				'nickname' => $this->getPost(''),
				'email' => $this->getPost('username'),
				'phone' => $this->getPost('signup_phone'),
				'password' => $this->getPost('signup_password'),
				'confirm' => $this->getPost('signup_password_confirm'),
				'code' => $this->getPost('signup_verifycode'),
			);
			if($form->validate() && $form->save()){
				$this->redirect(Yii::app()->getHomeUrl());
			}
		}
		
		$this->render('/login/index',array(
			'model' => $form,
			'isLogin' => false
		));
	}
}