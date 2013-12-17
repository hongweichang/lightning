<?php
/**
 * @name Admin.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-8 
 * Encoding UTF-8
 */
class Admin extends Controller{
	public $layout='main';
	public $defaultAction = 'index';
	public $subTabs = array();
	public $notifications = array();
	public $pluginUrl;
	
	public function init(){
		$app = Yii::app();
		$app->setPath('js','UED/backend/javascript/');
		$app->setPath('css','UED/backend/css/');
		$app->setPath('image','UED/backend/images/');
		parent::init();
		$this->pluginUrl = $this->app->getSiteBaseUrl().'plugins/';
		//$this->addToSubNav('首页','/'.$this->getModule()->name);
		parent::setPageTitle('闪电贷后台管理系统');
	}
	
	public function setPageTitle($value){
		parent::setPageTitle($value.' - 闪电贷后台管理系统');
	}
	
	public function accessRules(){
		$ipAllow = array(
				array('allow',
						'ips' => array('127.0.0.1'),
						'deniedCallback' => array($this,'accessDenied')
				),
		);
		return array_merge($ipAllow,parent::accessRules());
	}
	
	public function loginRequired(){
		$this->redirect($this->createUrl('account/login'));
	}
	
	/**
	 * 添加三级菜单
	 */
	public function addToSubTab($text,$route,$title='',$urlParams=array()){
		$url = $this->createUrl($route,$urlParams);
		$this->subTabs[] = "<li><a href='{$url}' class='default-tab' title='{$title}'>{$text}</a></li>";
	}
	
	/**
	 * 添加注意消息
	 * 可选的type有attention,information,success,error
	 */
	public function addNotifications($content,$type='attention'){
		$this->notifications[] = $this->renderPartial('/public/notification',array('content'=>$content,'type'=>$type),true);
	}
	
	public function filterPublicClientScript($filterChain){
		//$this->cs->registerCssFile($this->cssUrl.'reset.css');
		//$this->cs->registerCssFile($this->cssUrl.'style.css');
		
		$filterChain->run();
	}
	
	public function showMessage($message,$redirectUrl='',$wait=5,$terminate=true){
		$url = $redirectUrl === '' ? $this->createUrl('index/welcome') : $this->createUrl($redirectUrl);
		
		$this->renderPartial('/public/flash',array(
				'waitSeconds' => $wait,
				'jumpUrl' => $url,
				'message' => $message
		));
		if ( $terminate === true ){
			$this->app->end();
		}
	}
	
	public function registerTreePlugin($treetableFunctions=array()){
		$cs = $this->cs;
		$url = $this->pluginUrl;
	
		$funcs = '';
		foreach ( $treetableFunctions as $func ){
			$funcs .= $func.';';
		}
		$script = '$(function(){var options = {expandable: true,};$("#tree").treetable(options);'.$funcs.'});';
		
		$cs->registerScriptFile($url.'treetable/javascripts/src/jquery.treetable.js',CClientScript::POS_END);
		$cs->registerScript('tree',$script,CClientScript::POS_END);
		$cs->registerCssFile($url.'treetable/stylesheets/jquery.treetable.css');
		$cs->registerCssFile($url.'treetable/stylesheets/jquery.treetable.theme.default.css');
	}
	
	public function accessDenied(){
		$this->showMessage('您无权访问此页面','index/welcome');
	}
}