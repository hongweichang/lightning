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
		if ( isset($config['criteria']) ){
			$criteria = $config['criteria'];
			if ( is_array($criteria) ){
				$criteria = new CDbCriteria($criteria);
			}
		}else {
			$criteria = new CDbCriteria();
		}
		$config['criteria'] = $criteria;
		
		if ( isset($config['countCriteria']) ){
			$countCriteria = $config['countCriteria'];
			if ( is_array($countCriteria) ){
				$countCriteria = new CDbCriteria($countCriteria);
			}
		}else {
			$countCriteria = new CDbCriteria();
		}
		$config['countCriteria'] = $countCriteria;
		
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