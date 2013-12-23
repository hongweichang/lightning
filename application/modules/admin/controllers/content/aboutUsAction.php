<?php
/**
 * @name aboutUsAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-22 
 * Encoding UTF-8
 */
class aboutUsAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$controller->addToSubtab('添加关于我们','content/aboutUsAdd');
		$controller->tabTitle = '关于我们';
		$controller->artList(2);
	}
}