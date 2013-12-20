<?php
/**
 * @name NotifyModule.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-26 
 * Encoding UTF-8
 */
class NotifyModule extends CmsModule{
	public $email;
	public $manager = array();
	
	public function init(){
		parent::init();
		Yii::import('notify.models.*');
		Yii::import('notify.components.*');
		
		$this->email['class'] = 'notify.components.EmailManager';
		$this->manager['class'] = 'notify.components.NotifyManager';
		$this->setComponents(array(
				'mailer' => $this->email,
				'notifyManager' => $this->manager,
		));
	}
	
	public function registerEvent(){
		
	}
}