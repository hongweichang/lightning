<?php

class PayModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		$config = require Yii::getPathOfAlias('pay.config.main').'.php';
		$this->configure($config);
		// import the module-level models and components
		$this->setImport(array(
			'pay.models.*',
			'pay.components.*',
			'pay.extensions.alipay.*'
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
