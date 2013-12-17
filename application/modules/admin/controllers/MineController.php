<?php
/**
 * @name MineController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-9 
 * Encoding UTF-8
 */
class MineController extends Admin{
	public function filters(){
		$filters = parent::filters();
		unset($filters['accessControl']);
		return $filters;
	}
	
	public function actionInfo(){
		$post = $this->getPost('PersonalInfoForm');
		$model = new PersonalInfoForm();
		if ( $post !== null ){
			$model->attributes = $post;
			if ( $model->validate() ){
				
			}
		}else {
			$user = Administrators::model()->find('id=:id',array(':id'=>$this->user->getId()));
			$model->attributes = $user->attributes;
			$model->password = null;
		}
		
		$this->render('info',array('model'=>$model));
	}
}