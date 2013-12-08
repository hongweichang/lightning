<?php
class AdminModule extends CmsModule
{
	public function init()
	{
		parent::init();
		$this->defaultController = 'index';
		$this->setImport(array(
			'adminnogateway.components.*',
			'adminnogateway.models.*',
			'adminnogateway.models.forms.*',
		));
	}
}
