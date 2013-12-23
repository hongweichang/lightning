<?php
/**
 * @name officialHelpEditAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-13 
 * Encoding UTF-8
 */
class officialHelpEditAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$controller->tabTitle = '编辑帮助';
		$controller->addToSubTab('帮助列表','content/officialHelp');
		$controller->addToSubTab('添加帮助','content/officialHelpAdd');
		$controller->artEdit(1);
	}
}