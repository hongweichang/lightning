<?php

class UserModule extends CmsModule{
	public function init(){
		parent::init();
		Yii::import('user.models.*');
		Yii::import('user.components.*');
		Yii::import('application.modules.credit.models.*');
		Yii::import('application.modules.tender.models.*');
		
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