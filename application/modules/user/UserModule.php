<?php

class UserModule extends CmsModule{
	public function init(){
		parent::init();
		Yii::import('user.models.*');
		Yii::import('user.components.*');
		
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