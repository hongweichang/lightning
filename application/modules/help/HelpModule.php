<?php 
class HelpModule extends CmsModule{
	public function init(){
		parent::init();
		
		$this->setImport(array(
			'user.models.*',
			'help.models.*',
			'help.components.*'
		));
		
		/*$this->setComponents(array(
			'bidManager' => array(
				'class' => 'BidManager',
			),
		));*/
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
?>