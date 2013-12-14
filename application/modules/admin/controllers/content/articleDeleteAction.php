<?php
/**
 * @name articleDeleteAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-13 
 * Encoding UTF-8
 */
class articleDeleteAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$controller->artDelete();
	}
}