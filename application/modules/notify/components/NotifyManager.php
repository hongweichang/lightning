<?php
/**
 * @name NotifyManager.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-26 
 * Encoding UTF-8
 */
class NotifyManager extends CApplicationComponent{
	
	public function getSettingProvider($config){
		return new CActiveDataProvider('NotificationSettings',$config);
	}
	
	public function getSettingProviderByType($type,$config){
		Utils::resovleProviderConfigCriteria($config);
		$criteria = $config['criteria'];
		$countCriteria = $config['countCriteria'];
		
		$criteria->addCondition('notify_type=:type');
		$criteria->params[':type'] = $type;
		$countCriteria->addCondition('notify_type=:type');
		$countCriteria->params[':type'] = $criteria->params[':type'];
		
		return new CActiveDataProvider('NotificationSettings',$config);
	}
	
	public function update($id,$attributes){
		return NotificationSettings::model()->updateByPk($id, $attributes);
	}
	
	public function save($attributes){
		$model = new NotificationSettings();
		$model->attributes = $attributes;
		if ( $model->validate() ){
			return $model->save(false);
		}else {
			return $model;
		}
	}
	
	public function getInstance($id){
		return NotificationSettings::model()->findByPk($id);
	}
}