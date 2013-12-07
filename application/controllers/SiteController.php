<?php
/**
 * @name SiteController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-24 
 * Encoding UTF-8
 */
class SiteController extends Controller{
	public function noneLoginRequired(){
		return 'index,test';
	}
	
	public function actionIndex(){
		$this->cs->registerCssFile($this->cssUrl.'index.css');
		$this->cs->registerScriptFile($this->scriptUrl.'slide_fade.js',CClientScript::POS_END);
		$this->render('index');
	}
	
	public function actionTest(){
		//var_dump($this->app->getEventHandlers('onEndRequest'));
		$async = $this->app->getComponent('asyncEventRunner');
		//$async->raiseAsyncEvent('onRegisterSuccess',array('data'=>'sasa'));
	}
}