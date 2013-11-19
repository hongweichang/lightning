<?php
class CreditController extends CmsController{
	public function filters(){
		return array();
	}

	public function init(){
		parent::init();
		if(isset($_POST['PHPSESSID']))
			session_id($_POST['PHPSESSID']);
	
	}

	public function actionCreditAdd(){
		$model = new CreditSettings();
		if(isset($_POST['Credit'])){
			$model->attributes = $_POST['Credit'];
			if($model->save())
				echo "ok";
		}
	}

	public function actionIndex(){
		echo "ok";
	}
}

?>