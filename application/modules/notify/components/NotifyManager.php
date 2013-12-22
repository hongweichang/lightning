<?php
/**
 * @name NotifyManager.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-26 
 * Encoding UTF-8
 */
class NotifyManager extends CApplicationComponent{
	public $smsAPI;//第三方短信接口地址
	public $cacheID;
	
	public function init(){
		$this->attachBehavior('curl','CurlBehavior');
		$this->attachBehavior('curlMulti','CurlMultiBehavior');
	}
	
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
	
	public function sendSms($target,$content){
		$curl = $this->curl;
		$curl->setMethod('POST');
		$url = $this->smsAPI;
		$curl->setRequestBody(array(
				'mobile' => $target,
				'content' => $content
		));
		$curl->setHeader(array(
				'Accept-Charset: GB2312',
				'Content-Type: application/x-www-form-urlencoded;charset:GB2312'
		));
		$curl->curlSend($url);
		if ( $curl->getHasError() ){
			return $curl->getError();
		}else {
			var_dump($curl->getOutput());die;
			return true;
		}
	}
	
	public function generateCode($length=4){
		$letters = 'bcdfghjklmnpqrstvwxyz';
		$vowels = 'aeiou';
		$code = '';
		for($i = 0; $i < $length; ++$i)
		{
			if($i % 2 && mt_rand(0,10) > 2 || !($i % 2) && mt_rand(0,10) > 9)
				$code.=$vowels[mt_rand(0,4)];
			else
				$code.=$letters[mt_rand(0,20)];
		}
		
		return $code;
	}
	
	public function verifyMobileCode($mobile,$code){
		$cache = Yii::app()->getComponent($this->cacheID);
	}
}