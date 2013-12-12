<?php
/**
 * @name categoryAddAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-12 
 * Encoding UTF-8
 */
class categoryAddAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$content = $controller->getContentManager();
		$controller->addToSubtab('分类列表','content/categoryList');
		$controller->tabTitle = '添加分类';
		$result = $content->saveCategory($this->getPost('CategoryForm'),true);
		if ( $result === true ){
			$controller->showMessage('添加成功','content/categoryList');
		}
		
		$this->render('categoryForm',array('model'=>$result,'action'=>$this->createUrl('content/categoryAdd')));
	}
}