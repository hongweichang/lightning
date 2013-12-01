<?php
/**
 * file: Controller.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-28
 * desc: 
 */
class Controller extends CmsController{
	public $layout='/layouts/main';
	
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
	
		$this->cssUrl = $homeUrl.'UED/backstage/css/';
		$this->scriptUrl = $homeUrl.'UED/backstage/javascript/';
		$this->imageUrl = $homeUrl.'UED/backstage/images/';
	}
	
	public function filters(){
		return array(
		);
	}
}