<?php
/**
 * @name addAction.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-5
 * Encoding UTF-8
 */
class addAction extends CmsAction{
	public function run(){
		$model = $this->app->getAuthManager()->getItemModel(AuthManager::GROUP);
		
		$className = get_class($model);
		$post = $this->getPost($className,null);
		if ( $post !== null ){
			$model->attributes = $post;
				
			if ( $model->save() ){
				$this->getController()->showMessage('添加成功','group/view');
			}
		}
		
		$formConfig = $this->getController()->getFormConfig();
		
		$form = new CForm($formConfig,$model);
		$this->setPageTitle('添加用户组');
		
		$this->render('add',array('form'=>$form));
	}
}