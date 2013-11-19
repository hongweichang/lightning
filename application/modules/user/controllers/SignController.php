<?php
/**
 * file: LoginController.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-18
 * desc: 登录模块
 */
class SignController extends Controller{
	public function filters(){
		return array();
	}
	
	public function actionIndex(){
		$this->render("index");
	}
	
	public function actionLogout(){
		Yii::app()->user->logout();
		$this->redirect($this->app->getHomeUrl());
	}
	
	public function actionLogin(){
		if($this->getPost('username') && $this->getPost('password')){
			$model = new LoginForm();
			$model->attributes = array(
				'username' => $this->getPost('username'),
				'password' => $this->getPost('password'),
				'keey' => $this->getPost('keepSignIn')
			);
			if($model->validate() && $model->login()){
				
			}
		}
		
		$this->render("index");
	}
	
	public function actionSignup(){
		if(!empty($this->getPost())){
			$model = new FrontUser();
			$model->attributes = array(
				//'email'
			);
		}
	}
}