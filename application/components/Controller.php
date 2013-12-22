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
	/**
	 * 
	 * @var Application
	 */
	public $app;
	
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
			$redirect = urlencode($this->app->hostName.$this->request->requestUri);
			$this->redirect($this->createUrl('/user/account/loginTransit',array('redirect'=>$redirect)));
		}
	}
	
	public function init(){
		parent::init();
		
		parent::setPageTitle('闪电贷');
		$this->user = $this->app->getUser();
		$this->cs = $this->app->getClientScript();
		
		$this->cssUrl = $this->app->getPartedUrl('css');
		$this->scriptUrl = $this->app->getPartedUrl('js');
		$this->imageUrl = $this->app->getPartedUrl('image');
	}
	
	public function setPageTitle($value){
		parent::setPageTitle($value.' - 闪电贷');
	}
	
	public function filterPublicClientScript($filterChain){
		$this->cs->registerCssFile($this->cssUrl.'common.css');
		$filterChain->run();
	}

}