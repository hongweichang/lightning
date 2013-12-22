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
		$notify = $this->getModule()->getComponent('notifyManager');
		//var_dump($notify->sendSms('13629731636','测试【闪电贷】'));
		//var_dump($notify->generateCode(4));
	}
}