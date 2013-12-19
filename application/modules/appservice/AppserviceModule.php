<?php 

class AppServiceModule extends CmsModule{
	public function init(){
		$app = Yii::app();
		parent::init();
		
		Yii::import('application.modules.credit.models.*');
		Yii::import('application.modules.user.models.*');
		$app->getModule('tender');

		$this->setComponents(array(
				
		));
	}
}
?>