<?php
/**
 * @name aboutUsDeleteAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-22 
 * Encoding UTF-8
 */
class aboutUsDeleteAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$controller->artDelete();
	}
}