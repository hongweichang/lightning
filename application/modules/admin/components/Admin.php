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
	public $leftMenu = array();
	
	public function init(){
		$app = Yii::app();
		$app->setPath('js','UED/backstage/javascript/');
		$app->setPath('css','UED/backstage/css/');
		$app->setPath('image','UED/backstage/images/');
		parent::init();
		$this->pageTitle = '闪电贷后台管理系统';
		if ( $this->request->getIsAjaxRequest() === true ){
			$parentId = $this->getQuery('m',null);
			$this->leftMenu = $this->generateLeftMenu($parentId);
		}
	}
	
	public function generateLeftMenu($parentId){
		if ( empty($parentId) ){
			return array();
		}
	}
	
	public function filterPublicClientScript($filterChain){
		$this->cs->registerCssFile($this->cssUrl.'common.css');
		$this->cs->registerScriptFile($this->scriptUrl.'jquery-1.8.2.min.js',CClientScript::POS_END);
		$this->cs->registerScriptFile($this->scriptUrl.'ajaxMVC.js',CClientScript::POS_END);
		$filterChain->run();
	}
	
	public function showMessage($message,$redirectUrl,$wait=5,$terminate=true){
		$url = $this->createUrl($redirectUrl);
		$this->renderPartial('//common/flashMessage',array(
				'waitSeconds' => $wait,
				'jumpUrl' => $url,
				'msg' => $message
		));
		if ( $terminate === true ){
			$this->app->end();
		}
	}
}