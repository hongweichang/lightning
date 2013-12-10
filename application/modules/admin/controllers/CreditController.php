
<?php
/*
**用户个人信息管理
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/
class CreditController extends Admin{
	public function filters(){
		return array();
	}

	public function init(){
		parent::init();
		if(isset($_POST['PHPSESSID']))
			session_id($_POST['PHPSESSID']);
	
	}

/*
**后台添加信用项
*/
	public function actionCreditAdd(){
		$Creditmodel = new CreditSettings();
		$Rolemodel = new CreditRole();

		$post = $this->getPost();
		if(!empty($post)){
			$Creditmodel->verification_name = $post['CreditSettings']['verification_name'];
			$Creditmodel->verification_type = 'file';
			$Creditmodel->description = $post['CreditSettings']['description'];

			if($Creditmodel->save()){
				$verification_id = $Creditmodel->attributes['id'];

				foreach($post['CreditRole']['role'] as $value){
					$Rolemodel = new CreditRole();
					$Rolemodel->role = $value;
					$Rolemodel->verification_id = $verification_id;
					$Rolemodel->optional = 1;
					$Rolemodel->grade = $post['CreditRole']['grade'];

					$Rolemodel->save();
				}
				$this->redirect(Yii::app()->createUrl('adminnogateway/credit/creditAdd'));

				
			}else
				var_dump($Creditmodel->getErrors());
		}

		$this->render('creditAdd',array('Creditmodel'=>$Creditmodel,'Rolemodel'=>$Rolemodel));
	}

/*
**信用项列表
*/
	public function actionCreditList(){
		$criteria = new CDbCriteria;
		$criteria->select = 'verification_name,description,verification_type';
		$criteria->order = 'id DESC';
		$creditData = CreditSettings::model()->findAll($criteria);

		if(!empty($creditData)){
			$this->render('creditList',array('creditData'=>$creditData));
		}

	}
	

	
}

?>