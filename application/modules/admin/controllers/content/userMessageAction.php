<?php
/**
 * @name userMessageAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-16 
 * Encoding UTF-8
 */
class userMessageAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$controller->tabTitle = '留言列表';
	
		$controller->addToSubTab('提问列表','content/faq');
	
		$controller->faqList(2);
	}
}