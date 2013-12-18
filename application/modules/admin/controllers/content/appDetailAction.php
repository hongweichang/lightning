<?php
/**
 * @name appDetailAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-15 
 * Encoding UTF-8
 */
class appDetailAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		
		$controller->addToSubTab('app动态列表','content/app');
		$controller->addToSubTab('添加app动态','content/appAdd');
		
		$controller->bannerDetail(1,'appDetail');
	}
}