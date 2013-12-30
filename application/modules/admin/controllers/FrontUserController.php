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
		$id = $this->getQuery('id');
		$data = $this->getPost('FrontUserEditForm',null);
		$form = new FrontUserEditForm();
		if ( $data !== null ){
			$data['id'] = $id;
			$form->attributes = $form;
			if ( $form->validate() ){
				$form->save();
				$this->showMessage('修改成功','frontUser/view');
			}
		}
		
		
	}
}