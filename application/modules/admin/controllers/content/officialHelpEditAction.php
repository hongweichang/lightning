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
		$controller->tabTitle = '编辑官方宝典';
		$controller->addToSubTab('官方宝典','content/officialHelp');
		$controller->addToSubTab('添加官方宝典','content/officialHelpAdd');
		$controller->artEdit(1);
	}
}