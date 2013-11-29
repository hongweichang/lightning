<?php

class IndexController extends Controller{	
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