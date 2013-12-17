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
	public $tabTitle = '';
	public $pluginUrl;
	
	public function init(){
		$app = Yii::app();
		$app->setPath('js','UED/backend/javascript/');
		$app->setPath('css','UED/backend/css/');
		$app->setPath('image','UED/backend/images/');
		parent::init();
		$this->pluginUrl = $this->app->getSiteBaseUrl().'plugins/';
		parent::setPageTitle('闪电贷后台管理系统');
		$this->actionClassPathAlias = $this->getModule()->name.'.controllers';
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
	public function addNotifications($content,$type='information',$noClose=false){
		$this->notifications[] = $this->renderPartial('/public/notification',array('content'=>$content,'type'=>$type,'noClose'=>$noClose),true);
	}
	
	public function filterPublicClientScript($filterChain){
		//$this->cs->registerCssFile($this->cssUrl.'reset.css');
		//$this->cs->registerCssFile($this->cssUrl.'style.css');
		
		$filterChain->run();
	}
	
	public function showMessage($message,$redirectUrl='',$createUrl=true,$wait=5,$terminate=true,$htmlOptions=array()){
		if ( $createUrl === true ){
			$url = $redirectUrl === '' ? $this->createUrl('index/welcome') : $this->createUrl($redirectUrl);
		}else {
			$url = $redirectUrl;
		}
		
		$this->renderPartial('/public/flash',array(
				'waitSeconds' => $wait,
				'jumpUrl' => $url,
				'message' => $message,
				'htmlOptions' => $htmlOptions
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
	
	public function loginRequired(){
		$url = $this->request->urlReferrer;
		$loginUrl = $this->createAbsoluteUrl('account/login');
		$compare = $this->createAbsoluteUrl('index/menu');
		
		if ( $url !== $compare ){
			$this->redirect($loginUrl);
		}else {
			$this->layout = false;
			$this->render('/public/loginRedirect',array('url'=>$loginUrl));
			$this->app->end();
		}
	}
	
	public function actionIndex(){
		$this->redirect($this->createUrl('index/welcome'));
	}
}