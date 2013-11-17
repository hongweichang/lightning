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

/*
**后台添加审核项
*/
	public function actionCreditAdd(){
		$model = new CreditSettings();
		if(isset($_POST['Credit'])){
			$model->attributes = $_POST['Credit'];
			if($model->save())
				echo "ok";
			else
				var_dump($model->getErrors());
		}
	}

/*
**后台管理添加项
*/
	public function actionCreditGet(){
		$criteria = new CDbCriteria;
		$criteria->select = 'verification_name,description,verification_type';
		$criteria->order = 'id DESC';
		$crediteData = CreditSettings::model()->findAll($criteria);
		var_dump($crediteData);
	}

	
}

?>