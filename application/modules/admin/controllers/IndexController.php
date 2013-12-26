<?php

class IndexController extends Admin{
	
	public function actionIndex(){
		$this->layout = 'frameset';
		$this->render('index');
	}
	
	public function actionMenu(){
		$cache = $this->app->cache;
		$authMenu = $this->app->getAuthManager()->getMenu();
		
		if ( $cache !== null ){
			$cacheKey = 'ADMIN_MENU_CACHE_'.$this->user->getId();
			$this->menu = $cache->get($cacheKey);
			if ( $this->menu === false ){
				$this->menu = $authMenu->generateUserMenu($this->user->getId());
				$cache->set($cacheKey,$this->menu,$this->getModule()->userAuthTimeout);
			}
		}else {
			$this->menu = $authMenu->generateUserMenu($this->user->getId());
		}
		
		$this->layout = false;
		$this->render('menu');
	}
	
	public function actionWelcome(){
		$this->pageTitle = '欢迎使用';
		$this->layout = 'welcome';
		$this->render('welcome');
	}
}