<?php
/**
 * @name VarnishTestController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-24 
 * Encoding UTF-8
 */
class VarnishTestController extends Controller{
	public function filters(){
		return array();
	}
	
	public function actionIndex(){
		if ( isset($_SERVER['FromVarnish']) && $_SERVER['FromVarnish'] === 'yes' ){
			echo 'yes';
		}else {
			echo 'no';
		}
	}
}