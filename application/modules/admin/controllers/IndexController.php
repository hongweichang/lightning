<?php

class IndexController extends Admin{
	
	public function actionIndex(){
		$this->layout = 'frameset';
		$this->render('index');
	}
	
	public function actionMenu(){
		$authMenu = $this->app->getAuthManager()->getMenu();
		
		$this->menu = $authMenu->generateUserMenu($this->user->getId());
		$this->layout = false;
		$this->render('menu');
	}
	
	public function actionWelcome(){
		$this->pageTitle = '欢迎使用';
		$this->layout = 'welcome';
		$this->render('welcome');
	}
}