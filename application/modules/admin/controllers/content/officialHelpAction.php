<?php
/**
 * @name officialHelpAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-13 
 * Encoding UTF-8
 */
class officialHelpAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$controller->addToSubtab('添加官方宝典','content/officialHelpAdd');
		$controller->tabTitle = '官方宝典';
		$controller->artList(1);
	}
}