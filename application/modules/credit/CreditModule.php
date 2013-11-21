<?php 

class CreditModule extends CmsModule{
	public function init(){
		parent::init();
		Yii::import('application.modules.credit.models.*');
		Yii::import('application.modules.credit.components.*');
	}
}
?>