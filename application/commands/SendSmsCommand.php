<?php
/**
 * @name SendSmsCommand.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-18 
 * Encoding UTF-8
 */
class SendSmsCommand extends CConsoleCommand{
	public function actionVerifyMobile($params=''){
		$data = json_decode($params,true);
		$event = $data['eventName'];
		$parameters = $data['params'];
		
		
	}
}