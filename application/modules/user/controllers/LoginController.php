<?php
/**
 * file: LoginController.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-20
 * desc: 登录模块
 */
class LoginController extends Controller{
	
	public function filters(){
		return array();
	}
	
	public function actionIndex(){
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
	
		$this->render('index',array(
			'model' => $form,
			'isLogin' => true
		));
	}
	
	public function actionLogout(){
		Yii::app()->user->logout();
		$this->redirect($this->app->getHomeUrl());
	}
}