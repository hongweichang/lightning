<?php

class IndexController extends Admin{
	
	public function actionIndex(){
		$this->layout = 'frameset';
		$this->render('index');
	}
	
	public function actionMenu(){
		$cache = $this->app->cache;
		$authMenu = $this->app->getAuthManager()->getMenu();
		$calc = $this->app->getAuthManager()->getCalculator();
		
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
		
		//是否提示标段未审核数量
		$verifyTips = -1;
		if ( $cache !== null ){
			$cacheKey = 'ADMIN_VERIFY_TIPS_'.$this->user->getId();
			$tip = $cache->get($cacheKey);
			if ( $tip === false ){
				$permissions = $calc->run($this->user->getId());
				foreach ( $permissions as $permission ){
					if ( $permission->id == 21 ){
						$verifyTips = 1;
						break;
					}
				}
				$cache->set($cacheKey, $verifyTips);
			}
		}else {
			$permissions = $calc->run($this->user->getId());
			foreach ( $permissions as $permission ){
				if ( $permission->id == 21 ){
					$verifyTips = 1;
					break;
				}
			}
		}
		
		$this->layout = false;
		$this->render('menu',array('verifyTips'=>$verifyTips));
	}
	
	public function actionWelcome(){
		$this->pageTitle = '欢迎使用';
		$this->layout = 'welcome';
		$this->render('welcome');
	}
}