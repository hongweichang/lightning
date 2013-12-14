<?php
/**
 * @name officialHelpAddAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-13 
 * Encoding UTF-8
 */
class officialHelpAddAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$controller->addToSubtab('官方宝典','content/officialHelp');
		$controller->tabTitle = '添加官方宝典';
		$controller->artAdd(1);
	}
}