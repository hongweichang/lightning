<?php
/**
 * @name categoryDeleteAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-12 
 * Encoding UTF-8
 */
class categoryDeleteAction extends CmsAction{
	public function run(){
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('index/welcome')));
		$id = $this->getQuery('id',null);
		$controller = $this->getController();
		$content = $controller->getContentManager();
		
		$result = $content->deleteCategory($id);
		if ( $result ){
			$controller->showMessage('删除成功',$redirect,false);
		}else {
			$controller->showMessage('删除失败，管理员不存在',$redirect,false);
		}
	}
}