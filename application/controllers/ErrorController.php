<?php
/**
 * @name ErrorController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2014-1-17 
 * Encoding UTF-8
 */
class ErrorController extends Controller{
	public function actionIndex(){
		$error = $this->app->getErrorHandler()->getError();
		if ( $error != NULL && $error['code'] == 500 ){
			$this->render('500');
		}else{
			$this->render('404');
		}
	}
}