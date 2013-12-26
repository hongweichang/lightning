<?php
/**
 * @name SendMailCommand.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-8 
 * Encoding UTF-8
 */
class SendMailCommand extends NotifyCommandBase{
	public function actionIndex($a,$b){
		$async = Yii::app()->getComponent('asyncEventRunner');
		$async->raiseAsyncEvent('onRegisterSuccess',array('a'=>$a,'b'=>$b));
	}
	
	public function actionBidVerifySuccess($params=''){
		
	}
}