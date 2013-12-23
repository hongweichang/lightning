<?php
/**
 * @name aboutUsEditAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-22 
 * Encoding UTF-8
 */
class aboutUsEditAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$controller->tabTitle = '编辑关于我们';
		$controller->addToSubTab('关于我们','content/aboutUs');
		$controller->addToSubTab('添加关于我们','content/aboutUsAdd');
		$controller->artEdit(2);
	}
}