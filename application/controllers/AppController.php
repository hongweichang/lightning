<?php
/**
 * @name AppController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2014-1-21 
 * Encoding UTF-8
 */
class AppController extends Controller{
	public function noneLoginRequired(){
		return 'android,ios';
	}
	
	public function actionAndroid(){
		$this->request->xSendFile('/app/shandiandai.apk',array(
			'xHeader' => 'X-Accel-Redirect'	
		));
	}
	
	public function actionIos(){
		echo 'Not Available';
	}
}