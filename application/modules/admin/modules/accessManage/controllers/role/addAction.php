<?php
/**
 * @name addAction.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-4
 * Encoding UTF-8
 */
class addAction extends CmsAction{
	public function run(){
		$model = $this->app->getAuthManager()->getItemModel(AuthManager::ROLE);
		
		$className = get_class($model);
		$post = $this->getPost($className,null);
		if ( $post !== null ){
			$model->attributes = $post;
				
			if ( $model->save() ){
				$this->redirect($this->createUrl('role/view'));
			}
		}
		
		$formConfig = $this->getController()->getFormConfig($model);
		
		$form = new CForm($formConfig,$model);
		$this->setPageTitle('添加角色');
		
		$this->render('add',array('form'=>$form));
	}
}