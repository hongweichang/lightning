<?php
/**
 * @name TestController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-14 
 * Encoding UTF-8
 */
class TestController extends CmsController{
	public function filters(){
		return array();
	}
	public function actionIndex(){
		echo 'succed';
	}
}