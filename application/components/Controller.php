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
	
	public function init(){
		parent::init();
		
		$homeUrl = $this->app->getHomeUrl();
		$this->cssUrl = $homeUrl.'css/';
		$this->scriptUrl = $homeUrl.'js/';
		$this->imageUrl = $homeUrl.'images/';
	}
}