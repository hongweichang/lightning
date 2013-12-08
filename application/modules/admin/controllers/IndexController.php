<?php

class IndexController extends Admin{
	public function noneLoginRequired(){
		return 'index,login';
	}
	
	public function actionIndex(){
		$this->render('index');
	}
	
	public function actionLogin(){
		$this->layout = '/layouts/login';
		$this->render('login');
	}
	
	public function actionLogout(){
		
	}
	
	public function actionError(){
		$this->render('index');
	}
}