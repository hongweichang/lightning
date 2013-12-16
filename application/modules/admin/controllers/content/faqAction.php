<?php
/**
 * @name faqAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-16 
 * Encoding UTF-8
 */
class faqAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$controller->tabTitle = '提问列表';
		
		$controller->addToSubTab('留言列表','content/userMessage');
		
		$controller->faqList(0);
	}
}