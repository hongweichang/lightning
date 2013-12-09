<?php
class AdminModule extends CmsModule
{
	public $name = 'admin';
	public function init()
	{
		parent::init();
		$this->defaultController = 'index';
		$this->setImport(array(
			$this->name.'.components.*',
			$this->name.'.models.*',
			$this->name.'.models.forms.*',
		));
		Yii::app()->setComponent('user',array(
				'class' => $this->name.'.components.AdminUser',
				'stateKeyPrefix' => 'AU',
				'allowAutoLogin' => false,
				'autoRenewCookie' => false,
				'guestName' => '游客',
				'authTimeout' => 3600,
		));
		Yii::setPathOfAlias('accessManage',dirname(__FILE__).DS.'modules'.DS.'accessManage');
		$this->setModules(array(
				'accessManage' => array(
						'class' => $this->name.'.modules.accessManage.AccessManageModule'
				),
		));
	}
}
