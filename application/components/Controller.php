<?php
/**
 * file: Controller.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-19
 * desc: P2P控制器基类
 */
class Controller extends CmsController{
	public $cssUrl;
	public $scriptUrl;
	public $imageUrl;
	/**
	 * 
	 * @var CWebUser
	 */
	public $user;
	/**
	 * 
	 * @var CClientScript
	 */
	public $cs;
	
	public function filters(){
		$filters = parent::filters();
		$filters['cs'] = 'publicClientScript';
		
		$noneLoginRequired = $this->noneLoginRequired();
		if ( $noneLoginRequired !== '' ){
			$filters['hasLogined'][0] = $filters['hasLogined'][0].' - '.$noneLoginRequired;
		}
		
		return $filters;
	}
	
	public function noneLoginRequired(){
		return '';
	}
	
	public function accessRules(){
		return array(
				array('allow',
						'users' => array('*')
				)
		);
	}
	
	public function loginRequired(){
		if ( $this->request->getIsAjaxRequest() === true ){
			$this->response(403,'请登录');
		}else {
			$this->redirect($this->createUrl('/user/account/login'));
		}
	}
	
	public function init(){
		parent::init();
		
		$this->user = $this->app->getUser();
		$this->cs = $this->app->getClientScript();
		$homeUrl = $this->app->getHomeUrl();
		
		$this->cssUrl = $homeUrl.'UED/css/';
		$this->scriptUrl = $homeUrl.'UED/javascript/';
		$this->imageUrl = $homeUrl.'UED/images/';
	}
	
	public function filterPublicClientScript($filterChain){
		$this->cs->registerCssFile($this->cssUrl.'common.css');
		$filterChain->run();
	}

}