<?php
/**
 * @name LightningCommandBase.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-23 
 * Encoding UTF-8
 */
class LightningCommandBase extends CConsoleCommand{
	public $eventName;
	public $parameters;
	public $app;
	
	public function init(){
		$this->app = Yii::app();
	}
	
	protected function beforeAction($action, $params){
		if ( !empty($params) ){
			$content = json_decode($params[0],true);
			if ( !empty($content) ){
				$this->eventName = $content['eventName'];
				$this->parameters = $content['params'];
			}else {
				return false;
			}
		}
		
		return parent::beforeAction($action, $params);
	}
}