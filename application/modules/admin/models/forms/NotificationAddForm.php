<?php
/**
 * @name NotificationAddForm.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-12 
 * Encoding UTF-8
 */
class NotificationAddForm extends CFormModel{
	public $event;
	public $event_name;
	public $content;
	public $enabled = 1;
	public $placeholders;
	
	public function rules(){
		return array(
				array('event,event_name,content,enabled','required','message'=>'请填写{attribute}'),
				array('placeholders','safe')
		);
	}
	
	public function attributeLabels(){
		return array(
				'event' => '事件',
				'event_name' => '事件名称',
				'content' => '通知内容',
				'enabled' => '是否启用',
				'placeholders' => '占位符'
		);
	}
	
	public function save($type){
		$data = $this->attributes;
		$data['notify_type'] = $type;
		return Yii::app()->getModule('notify')->getComponent('notifyManager')->save($data);
	}
}