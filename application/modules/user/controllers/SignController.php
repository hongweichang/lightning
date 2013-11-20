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
		$this->render("index",array(
			'model' => new LoginForm()
		));
	}
	
	public function actionLogout(){
		Yii::app()->user->logout();
		$this->redirect($this->app->getHomeUrl());
	}
	
	public function actionLogin(){
		$model = new LoginForm();
		if($this->getPost('username') && $this->getPost('password')){
			$model->attributes = array(
				'username' => $this->getPost('username'),
				'password' => $this->getPost('password'),
				'keey' => $this->getPost('keepSignIn')
			);
			if($model->validate() && $model->login()){
				
			}
		}
		
		$this->render('index',array(
			'model' => $model
		));
	}
	
	public function actionSignup(){
		$model = new FrontUser();
		
		$post = $this->getPost();
		if(!empty($post)){
			if(!$this->checkEmail($this->getPost('username'))){
				
			}
			if(!$this->checkPhone($this->getPost('signup_phone'))){
				
			}
			if(!$this->getPost('signup_password')){
				
			}
			if($this->getPost('signup_password') != $this->getPost('signup_password_confirm')){
				
			}
			$model->attributes = array(
				'email' => $this->getPost('username'),
				'phone' => $this->getPost('signup_phone'),
				'password' => $this->getPost('signup_password')
			);
			if($model->save()){
				
			}else{
				
			}
		}
		
		$this->render('index',array(
			'model' => $model
		));
	}
	
	private function checkEmail($email){
		return preg_match('#^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$#', $email);
	}
	
	private function checkPhone($phone){
		return preg_match('#^13\d{9}|14[57]\d{8}|15[012356789]\d{8}|18[01256789]\d{8}$#', $phone);
	}
}