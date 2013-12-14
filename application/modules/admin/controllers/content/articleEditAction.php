<?php
/**
 * @name articleEditAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-13 
 * Encoding UTF-8
 */
class articleEditAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$controller->tabTitle = '编辑文章';
		$controller->addToSubTab('文章列表','content/articleList');
		$controller->addToSubTab('添加文章','content/articleAdd');
		$controller->artEdit(0);
	}
}