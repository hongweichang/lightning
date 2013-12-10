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
		$user = Administrators::model()->find('id=:id',array(':id'=>$this->user->getId()));
		if ( $post !== null ){
			$post['model'] = $user;
			$model->attributes = $post;
			if ( $model->validate() && $model->save() ){
				$this->showMessage('修改成功','mine/info');
			}
		}else {
			$model->attributes = $user->attributes;
			$model->password = null;
		}
		$this->tabTitle = '修改信息';
		
		$this->render('info',array('model'=>$model));
	}
}