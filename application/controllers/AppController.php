<?php
/**
 * @name AppController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2014-1-21 
 * Encoding UTF-8
 */
class AppController extends Controller{
	public function actionAndroid(){
		$this->request->xSendFile(Yii::getPathOfAlias('application.app.shandiandai').'.apk');
	}
	
	public function actionIos(){
		echo 'Not Available';
	}
}