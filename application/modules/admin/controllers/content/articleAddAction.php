<?php
/**
 * @name articleAddAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-12 
 * Encoding UTF-8
 */
class articleAddAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$controller->addToSubtab('公告列表','content/articleList');
		$controller->tabTitle = '添加公告';
		$controller->artAdd(0);
	}
}