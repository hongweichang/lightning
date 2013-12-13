<?php
/**
 * @name articleListAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-12 
 * Encoding UTF-8
 */
class articleListAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$controller->addToSubtab('添加文章','content/articleAdd');
		$controller->tabTitle = '文章列表';
		$controller->artList(0);
	}
}