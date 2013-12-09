<?php

class PayModule extends CmsModule
{
	public $alipay;
	public $ips;
	
	public function init()
	{
		parent::init();
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		$config = require Yii::getPathOfAlias('pay.config.main').'.php';
		$this->configure($config);
		// import the module-level models and components
		$this->setImport(array(
			'user.models.*',
			'pay.models.*',
			'pay.components.*',
		));
		
		$this->setComponents(array(
			'fundManager' => array(
				'class' => 'FundManager',
			),
		));
		
		
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
