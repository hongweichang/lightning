<?php
/**
 * @name ContentModule.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-13 
 * Encoding UTF-8
 */
class ContentModule extends CmsModule{
	public function init(){
		parent::init();
		$this->defaultController = 'help';
		$this->setImport(array(
				'content.components.*',
				'content.models.*',
				'content.models.forms.*'
		));
		
		$this->setComponent('contentManager',array(
				'class' => 'content.components.ContentManager',
		));
	}
}