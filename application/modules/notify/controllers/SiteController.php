<?php
/**
 * @name SiteController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-26 
 * Encoding UTF-8
 */
class SiteController extends Controller{
	public function noneLoginRequired(){
		return 'index';
	}
	
	public function actionIndex(){
		$this->getModule()->getComponent('mailer');
	}
}