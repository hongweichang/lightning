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
		$controller->tabTitle = '编辑公告';
		$controller->addToSubTab('公告列表','content/articleList');
		$controller->addToSubTab('添加公告','content/articleAdd');
		$controller->artEdit(0);
	}
}