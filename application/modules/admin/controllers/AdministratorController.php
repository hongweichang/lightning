<?php
/**
 * @name AdministratorController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-10 
 * Encoding UTF-8
 */
class AdministratorController extends Admin{
	public function init(){
		parent::init();
		$this->addToSubTab('添加管理员','administrator/add');
		$this->addToSubTab('管理员列表','administrator/view');
	}
	
	public function actionView(){
		$criteria = new CDbCriteria();
		$this->app->getAuthManager();//load models
		new CPagination();
		$selector = Selector::load('AdministratorSelector',$this->getQuery('AdministratorSelector'),$criteria);
		$criteria->with = array(
				'baseUser' => array(
						'with' => array('authRoles'),
				),
		);
		$dataProvider = new CActiveDataProvider('Administrators',array(
				'criteria' => $criteria,
				'countCriteria' => array(
						'condition' => $criteria->condition,
						'params' => $criteria->params
				),
				'pagination' => array(
						'pageSize' => 15
				),
		));
		
		$this->tabTitle = '管理员列表';
		$this->addNotifications('搜索','information',true);
		$this->render('view',array('dataProvider'=>$dataProvider,'selector'=>$selector));
	}
	
	public function actionDelete(){
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('administrator/view')));
		$id = $this->getQuery('id',null);
		
		$model = Administrators::model()->with('baseUser')->findByPk($id);
		if ( $model !== null ){
			$model->delete();
			$this->showMessage('删除成功',$redirect,false);
		}else {
			$this->showMessage('删除失败，管理员不存在',$redirect,false);
		}
	}
	
	public function actionLock(){
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('administrator/view')));
		$id = $this->getQuery('id',null);
		$model = Administrators::model()->with('baseUser')->findByPk($id);
		if ( $model !== null ){
			$model->locked = $model->locked ^ 1;
			$model->update();
			$this->showMessage('锁定成功',$redirect,false);
		}else {
			$this->showMessage('锁定失败，管理员不存在',$redirect,false);
		}
	}
	
	public function actionAdd(){
		$post = $this->getPost('AdministratorForm');
		$form = new AdministratorForm();
		if ( $post !== null ){
			$form->attributes = $post;
			if ( $form->save() ){
				$this->showMessage('添加成功','administrator/view');
			}
		}
		
		$form->loadRoles();
		$this->tabTitle = '添加管理员';
		$this->render('form',array('model'=>$form,'action'=>$this->createUrl('administrator/add')));
	}
	
	public function actionEdit(){
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('administrator/view')));
		$id = $this->getQuery('id',null);
		
		$model =  Administrators::model()->findByPk($id);
		if ( $model === null ){
			$this->showMessage('修改失败，管理员不存在',$redirect,false);
		}
		
		$post = $this->getPost('AdministratorForm');
		$form = new AdministratorForm();
		if ( $post !== null ){
			$post['model'] = $model;
			$form->attributes = $post;
			if ( $form->update() ){
				$this->showMessage('修改成功',$redirect,false);
			}
		}else {
			$form->attributes = $model->attributes;
			$form->password = null;
		}
		$form->loadRoles($id);
		$this->tabTitle = '修改信息';
		$this->render('form',array('model'=>$form,'action'=>$this->createUrl('administrator/edit',array('id'=>$id,'redirect'=>urlencode($redirect)) )));
	}
	
	public function actionLogs(){
		
	}
}