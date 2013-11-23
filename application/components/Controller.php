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
	
	public function init(){
		parent::init();
		
		$this->user = $this->app->getUser();
		$this->cs = $this->app->getClientScript();
		$homeUrl = $this->app->getHomeUrl();
		
		$this->cssUrl = $homeUrl.'UED/css/';
		$this->scriptUrl = $homeUrl.'UED/javascript/';
		$this->imageUrl = $homeUrl.'UED/images/';
	}

}