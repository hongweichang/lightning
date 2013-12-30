<?php
/**
 * @name FrontUserController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-10 
 * Encoding UTF-8
 */
class FrontUserController extends Admin{
	public function actionView(){
		$criteria = new CDbCriteria();
		$this->app->getModule('user');//加载模块model
		
		$selector = Selector::load('FrontUserSelector',$this->getQuery('FrontUserSelector'),$criteria);
		
		$dataProvider = new CActiveDataProvider('FrontUser',array(
				'criteria' => $criteria,
				'countCriteria' => array(
						'condition' => $criteria->condition,
						'params' => $criteria->params
				),
				'pagination' => array(
						'pageSize' => 15
				),
		));
		
		$this->tabTitle = '用户列表';
		$this->addToSubTab('导出用户数据','excelOutput/userDataOutPut');
		$this->addNotifications('搜索','information',true);
		$this->render('view',array('dataProvider'=>$dataProvider,'selector'=>$selector));
	}
	
	public function actionEdit(){
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('frontUser/view')));
		$id = $this->getQuery('id');
		$this->app->getModule('user');
		
		$model =  FrontUser::model()->findByPk($id);
		if ( $model === null ){
			$this->showMessage('修改失败，用户不存在',$redirect,false);
		}
		
		$post = $this->getPost('FrontUserEditForm',null);
		$form = new FrontUserEditForm();
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
		
		$this->tabTitle = '修改信息';
		$this->render('form',array('model'=>$form,'action'=>$this->createUrl('frontUser/edit',array('id'=>$id,'redirect'=>urlencode($redirect)) )));
	}
}