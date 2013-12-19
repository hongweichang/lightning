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

			$Creditmodel->verification_name = $post['title'];
			$Creditmodel->verification_type = 'file';
			$Creditmodel->description = $post['description'];

			if($Creditmodel->save()){
				$verification_id = $Creditmodel->attributes['id'];

				if($post['wddz'] != null){
					$Rolemodel = new CreditRole();
					$Rolemodel->role = 'wddz';
					$Rolemodel->verification_id = $verification_id;
					$Rolemodel->optional = $post['wddz'];
					$Rolemodel->grade = $post['grade'];

					$Rolemodel->save();
				}

				if($post['qyz'] != null){
					$Rolemodel = new CreditRole();
					$Rolemodel->role = 'qyz';
					$Rolemodel->verification_id = $verification_id;
					$Rolemodel->optional = $post['qyz'];
					$Rolemodel->grade = $post['grade'];

					$Rolemodel->save();

				}

				if($post['gxjc'] != null){
					$Rolemodel = new CreditRole();
					$Rolemodel->role = 'gxjc';
					$Rolemodel->verification_id = $verification_id;
					$Rolemodel->optional = $post['gxjc'];
					$Rolemodel->grade = $post['grade'];

					$Rolemodel->save();
				}
				$this->redirect($this->createUrl('credit/creditlist'));

				
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
		$this->addToSubTab('添加信用项','credit/creditAdd');
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
			$Creditmodel = $creditData[0];

			$post = $this->getPost();

			if(!empty($post)){
				var_dump($post);
				$Creditmodel->verification_name = $post['title'];
				$Creditmodel->verification_type = 'file';
				$Creditmodel->description = $post['description'];

				if($Creditmodel->save()){
					$verification_id = $id;

					if(!empty($roleData)){
						foreach($roleData as $value){
							$value->delete();
						}
					}
					if($post['wddz'] != null){
						$Rolemodel = new CreditRole();
						$Rolemodel->role = 'wddz';
						$Rolemodel->verification_id = $verification_id;
						$Rolemodel->optional = $post['wddz'];
						$Rolemodel->grade = $post['grade'];

						$Rolemodel->save();
					}

					if($post['qyz'] != null){
						$Rolemodel = new CreditRole();
						$Rolemodel->role = 'qyz';
						$Rolemodel->verification_id = $verification_id;
						$Rolemodel->optional = $post['qyz'];
						$Rolemodel->grade = $post['grade'];

						$Rolemodel->save();

					}

					if($post['gxjc'] != null){
						$Rolemodel = new CreditRole();
						$Rolemodel->role = 'gxjc';
						$Rolemodel->verification_id = $verification_id;
						$Rolemodel->optional = $post['gxjc'];
						$Rolemodel->grade = $post['grade'];

						$Rolemodel->save();
					}
	
					$this->redirect($this->createUrl('credit/creditlist'));
				}else
					var_dump($Creditmodel->getErrors());

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
			$this->redirect($this->createUrl('credit/creditlist'));
		}
	}


/*
**添加会员级别
*/
	public function actionCreditLevelAdd(){
		$this->pageTitle = "添加会员等级";
		$model = new CreditGradeSettings();

		$post = $this->getPost();
		if(!empty($post)){
			$model->attributes = $post['CreditGradeSettings'];
			if($model->save()){
				$this->createUrl('credit/creditLevelList');
			}else
				var_dump($model->getErrors());
		}

		$this->render('creditLevelAdd',array('model'=>$model));
	}


/*
**会员级别列表
*/
	public function actionCreditLevelList(){
		$this->addToSubTab('添加会员级别','credit/creditLevelAdd');
		$criteria = new CDbCriteria;
		$criteria->order = 'start DESC';

		$LevelData = CreditGradeSettings::model()->findAll($criteria);

		if(!empty($LevelData)){
			$this->render('creditLevelList',array('LevelData'=>$LevelData));
		}
	}


/*
**编辑会员级别
*/
	public function actionCreditLevelUpdate($id){
		if(is_numeric($id)){
			$levelData = CreditGradeSettings::model()->findByPk($id);
			$post = $this->getPost();

			if(!empty($post)){
				$levelData->attributes = $post['CreditGradeSettings'];
				if($levelData->save())
					$this->redirect($this->createUrl('credit/creditLevelList'));
			}

			if(!empty($levelData)){
				$this->render('creditLevelUpdate',array('model'=>$levelData));
			}
		}
	}


/*删除会员级别*/
	public function actionCreditLevelDelete($id){
		if(is_numeric($id)){
			$levelData = CreditGradeSettings::model()->findByPk($id);

			if(!empty($levelData)){
				if($levelData->delete()){
					$this->redirect($this->createUrl('credit/creditLevelList'));
				}
				
			}
		}
	}
	
}

?>