<?php
/**
 * @name faqReplyAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-16 
 * Encoding UTF-8
 */
class faqReplyAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		
		$controller->tabTitle = '提问回复与查看';
		$controller->addToSubTab('提问列表','content/faq');
		$controller->faqReplyView(0);
	}
}