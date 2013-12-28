<?php
/*
**债权模块
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/

class DebtController extends Admin{
	public function filters(){
		$filters = parent::filters();
		return $filters;	
	}

	public function actionCreateDebt(){
		$model = new Debt;
		$post = $this->getPost();


		if(!empty($post)){
			$attributes = $post['Debt'];
			$model->attributes = $attributes;
			
			if($model->save()){
				$this->redirect(Yii::app()->createUrl('adminnogateway/debt/debtList'));
				
			}else{
				var_dump($model->getErrors());
			}

		}
		$this->render('createDebt',array('model'=>$model));
	}

	public function actionDebtList(){
		$debtData = Debt::model()->findAll();
		$this->addToSubTab('发布债权','debt/createDebt');
		$this->render('debtList',array('debtList'=>$debtData));
	}

	
	public function actionDebtUpdate($id){
		if(is_numeric($id)){
			$model= Debt::model()->findByPk($id);
			$post = $this->getPost();

			if(!empty($post['Debt'])){
				$model->attributes = $post['Debt'];

				if($model->save()){
					$this->redirect(Yii::app()->createUrl('adminnogateway/debt/debtList'));
				}else{
					var_dump($model->getErrors());
				}
			}

		$this->render('debtUpdate',array('model'=>$model));

		}
	}

	public function actionDebtDelete($id){
		if(is_numeric($id)){
			$model = Debt::model()->findByPk($id);
			if($model !== null){
				$model->delete();
				$this->redirect(Yii::app()->createUrl('adminnogateway/debt/debtList'));
			}
		}
	}
}
?>