<?php
/**
 * @name aboutUsAddAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-22 
 * Encoding UTF-8
 */
class aboutUsAddAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$controller->addToSubtab('关于我们','content/aboutUs');
		$controller->tabTitle = '添加关于我们';
		$controller->artAdd(2);
	}
}