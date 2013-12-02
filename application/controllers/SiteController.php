<?php
/**
 * @name SiteController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-24 
 * Encoding UTF-8
 */
class SiteController extends Controller{
	public function noneLoginRequired(){
		return 'index';
	}
	
	public function actionIndex(){
		
		$this->cs->registerCssFile($this->app->getCssUrl().'index.css');
		$this->cs->registerScriptFile($this->app->getJsUrl().'slide_fade.js',CClientScript::POS_END);
		$this->render('index');
	}
}