<?php
/**
 * @name addAction.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-3
 * Encoding UTF-8
 */
class addAction extends CmsAction{
	public function run(){
		$model = $this->app->getAuthManager()->getItemModel(AuthManager::OPERATION);
		
		$className = get_class($model);
		$post = $this->getPost($className,null);
		if ( $post !== null ){
			$post['module'] = $this->controller->module->parentModule->id;
			$model->attributes = $post;
			
			if ( $model->save() ){
				$assigner = $this->app->getAuthManager()->getAssigner();
				$assignData = array(
						'operation_id' => $model->primaryKey,
						'permission_name' => $model->operation_name,
						'description' => $model->description
				);
				$assigner->grant(AuthAssigner::ITEM_OPERATION,$assignData)->to(AuthAssigner::ITEM_PERMISSION)->doit();
				$this->getController()->showMessage('添加成功','operation/view');
			}
		}
		
		$formConfig = $this->getController()->getFormConfig($model);
		
		$form = new CForm($formConfig,$model);
		$this->setPageTitle('添加操作');
		
		$this->render('add',array('form'=>$form));
	}
}