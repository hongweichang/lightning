
<?php
/*
**信用项以及信用系统配置
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
				$this->redirect(Yii::app()->createUrl('adminnogateway/credit/creditlist'));

				
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
		$criteria->alias = 'credit';
		$criteria->select = 'credit.id,verification_name,description,verification_type';
		$criteria->order = 'credit.id DESC';
		$criteria->with = array(
						'CreditRole'=>array(
								'select'=>'role'
							)
					);
		$creditData = CreditSettings::model()->findAll($criteria);
		$creditList = array();
		$roleData = array();

		if(!empty($creditData)){
	
			foreach($creditData as $value){
				$creditList[] = array(
								'id'=>$value->id,
								'title'=>$value->verification_name,
								'description'=>$value->description,
								'roleData'=>$value->getrelated('CreditRole')
							);
			}
			$this->render('creditList',array('creditData'=>$creditList));
		}

	}

/*
**信用项编辑
*/
	public function actionCreditUpdate($id){
		if(is_numeric($id)){
			$criteria = new CDbCriteria;
			$Rolemodel = new CreditRole();
			$criteria->alias = 'credit';
			$criteria->condition = 'credit.id =:id';
			$criteria->params = array(
						':id'=>$id
				);

			$creditData = CreditSettings::model()->with('CreditRole')->findAll($criteria);
			$roleData = $creditData[0]->getRelated('CreditRole');
			if(!empty($roleData)){
				$roleGrade = $roleData[0]->grade;
				$roleSum = count($roleData);
				$Rolemodel->grade = $roleGrade;
			}

			$Creditmodel = $creditData[0];

			$post = $this->getPost();

			if(!empty($post)){
				$Creditmodel->verification_name = $post['CreditSettings']['verification_name'];
				$Creditmodel->verification_type = 'file';
				$Creditmodel->description = $post['CreditSettings']['description'];

				if($Creditmodel->save()){
					$verification_id = $id;

					$updateRoleSum = count($post['CreditRole']['role']);
					
					if(!empty($roleData)){
						foreach($roleData as $value){
							$value->delete();
						}
					}
					
						
					foreach($post['CreditRole']['role'] as $value){
						$Rolemodel = new CreditRole();
						$Rolemodel->role = $value;
						$Rolemodel->verification_id = $verification_id;
						$Rolemodel->optional = 1;
						$Rolemodel->grade = $post['CreditRole']['grade'];

						$Rolemodel->save();
					}
					$this->redirect(Yii::app()->createUrl('adminnogateway/credit/creditlist'));

				}

			}

		$this->render('creditUpdate',array('Creditmodel'=>$Creditmodel,'Rolemodel'=>$Rolemodel));


		}
	}


/*
**信用项删除
*/
	public function actionCreditDelete($id){
		if(is_numeric($id)){
			$creditData = CreditSettings::model()->findByPk($id);
			
			if(!empty($creditData)){
				$creditData->delete();
			}
			$this->redirect(Yii::app()->createUrl('adminnogateway/credit/creditlist'));
		}
	}

	
}

?>