<?php
/**
 * @name categoryEditAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-12 
 * Encoding UTF-8
 */
class categoryEditAction extends CmsAction{
	public function run(){
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('index/welcome')));
		$id = $this->getQuery('id',null);
		$controller = $this->getController();
		$content = $controller->getContentManager();
		$controller->addToSubTab('分类列表','content/categoryList');
		$controller->addToSubTab('添加分类','content/categoryAdd');
		
		$result = $content->updateCategory($id,$this->getPost('CategoryForm'));
		if ( $result === true ){
			$controller->showMessage('编辑成功',$redirect,false);
		}elseif ( $result->modelExists === false ){
			$controller->showMessage('编辑失败，分类不存在',$redirect,false);
		}
		
		$this->render('categoryForm',array('model'=>$result,'action'=>$this->createUrl('content/categoryEdit',array('id'=>$id,'redirect'=>urlencode($redirect)) ),'parents'=>$controller->artTypeMap ));
	}
}