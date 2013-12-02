<?php 

class TenderModule extends CmsModule{
	public function init(){
		parent::init();
		Yii::import('application.modules.tender.models.*');
		Yii::import('application.modules.tender.components.*');
	
	
		$this->setComponents(array(
					'BidManager' => array(
							'class' => 'BidManager',
							'cookieTimeout' => 864000
					),
		));
	}
}
?>