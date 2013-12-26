<?php
/**
 * @name NotifyCommandBase.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-27 
 * Encoding UTF-8
 */
class NotifyCommandBase extends LightningCommandBase{
	/**
	 *
	 * @var NotifyManager
	 */
	public $notify;
	public $placeholders;
	
	public function init(){
		parent::init();
		$this->notify = $this->app->getModule('notify')->getComponent('notifyManager');
	}
	
	public function beforeAction($action, $params){
		if ( parent::beforeAction($action, $params) === false ){
			return false;
		}
	
		$this->placeholders = isset($this->parameters['placeholders']) ? $this->parameters['placeholders'] : array();
	
		return true;
	}
}