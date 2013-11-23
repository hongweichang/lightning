<?php 

class BorrowModule extends CmsModule{
	public function init(){
		parent::init();
		Yii::import('application.modules.borrow.models.*');
		Yii::import('application.modules.borrow.components.*');
	}
}
?>