<?php
/**
 * @name NotificationForm.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-11 
 * Encoding UTF-8
 */
class NotificationForm extends CFormModel{
	public $id;
	public $event_name;
	public $content;
	public $enabled;
	public $placeholders;
	
	public function loadSetting($id){
		$model = Yii::app()->getModule('notify')->getComponent('notifyManager')->getInstance($id);
		if ( $model !== null ){
			$this->attributes = $model->attributes;
		}
		$this->placeholders = PlaceholderManager::getPlaceholderLables(explode(',',$this->placeholders));
	}
	
	public function rules(){
		return array(
				array('event_name,content,enabled','required','message'=>'请填写{attribute}'),
				array('placeholders','safe')
		);
	}
	
	public function attributeLabels(){
		return array(
				'event_name' => '事件名称',
				'content' => '通知内容',
				'enabled' => '是否启用'
		);
	}
	
	public function update(){
		$update = array(
				'event_name' => $this->event_name,
				'content' => $this->content,
				'enabled' => $this->enabled
		);
		return Yii::app()->getModule('notify')->getComponent('notifyManager')->update($this->id,$update);
	}
}