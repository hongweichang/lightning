<?php
class AdminModule extends CmsModule
{
	public $name = 'admin';
	public function init()
	{
		$app = Yii::app();
		parent::init();
		$this->defaultController = 'index';
		$this->setImport(array(
			$this->name.'.components.*',
			$this->name.'.models.*',
			$this->name.'.models.forms.*',
		));
		$app->setComponent('user',array(
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
		
		$app->getModule('credit');
		$app->getModule('user');
	}
	
	public function beforeControllerAction($controller, $action){
		if ( parent::beforeControllerAction($controller, $action) ){
			Yii::log("entering into [administrator module]. running [{$controller->id} controller].[{$action->id} action]",'admin','access.system');
			return true;
		}else {
			return false;
		}
	}
}
