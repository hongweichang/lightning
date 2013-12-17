<?php
/**
 * @name userMessageDeleteAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-16 
 * Encoding UTF-8
 */
class userMessageDeleteAction extends CmsAction{
	public function run(){
		$this->getController()->faqDelete();
	}
}