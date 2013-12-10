<?php

class UserModule extends CmsModule{
	public function init(){
		parent::init();
		Yii::import('user.models.*');
		Yii::import('user.components.*');
		$app = Yii::app();
		$app->getModule('credit');
		$app->getModule('tender');
		
		$this->setComponents(array(
				'userManager' => array(
						'class' => 'UserManager',
						'cookieTimeout' => 864000
				),

				'infoDisposeManager' => array(
						'class'=>'InfoDisposeManager',
					),
		));
	}
}
?>