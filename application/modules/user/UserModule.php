<?php

class UserModule extends CmsModule{
	public function init(){
		parent::init();
		Yii::import('application.modules.user.models.*');
		Yii::import('application.modules.user.components.*');
	}
}
?>