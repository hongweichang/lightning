<?php
/**
 * @name SendSmsCommand.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-18 
 * Encoding UTF-8
 * 
 * 发送过来的placeholders会取代action中默认的placeholders
 */
class SendSmsCommand extends NotifyCommandBase{
	public function beforeAction($action, $params){
		if ( parent::beforeAction($action, $params) === false ){
			return false;
		}
		
		return true;
	}
	
	protected function sendSms($placeholders=array()){
		if ( empty($this->parameters['mobile']) || $this->notify->checkMobileFormat($this->parameters['mobile']) === false ){
			return false;
		}
		
		$content = $this->notify->getSettingProviderByNameType($this->eventName,'sms')->getData();
		$holders = array_merge($placeholders,$this->placeholders);//替换默认的占位符为程序中自定义的占位符
		foreach ( $content as $c ){
			$this->notify->sendSms($this->parameters['mobile'],PlaceholderManager::replacePlaceholders($c->content,$placeholders));
		}
	}
	
	/**
	 * 发送手机短信验证码
	 */
	public function actionVerifyCode($params=''){
		$notify = $this->notify;
		
		$codeLifeTime = isset($this->parameters['codeLifeTime']) ? $this->parameters['codeLifeTime'] : 1800;
		$codeLength = isset($this->parameters['codeLength']) ? $this->parameters['codeLength'] : 4;
		
		$code = $notify->setMobileVerifyCode($this->parameters['mobile'].$this->eventName,$codeLifeTime,$codeLength);
		$this->sendSms(array(
				'{code}' => $code,
				'{codeLifeTime}' => $codeLifeTime / 60
		));
		
		return true;
	}
	
	public function actionBidVerifySuccess($params=''){
		if ( isset($this->parameters['bidId']) === false ){
			return false;
		}
		$notify = $this->notify;
		
		$bid = $this->app->getModule('tender')->getComponent('bidManager')->getBidInfo($this->parameters['bidId']);
		
		if ( $bid === null ){
			return false;
		}
		
		$this->parameters['mobile'] = $bid->user->mobile;
		$this->sendSms(array(
				'{bid}' => $bid->title,
				'{userName}' => $bid->user->nickname
		));
	}
	
	public function actionBidVerifyFailed($params=''){
		if ( isset($this->parameters['bidId']) === false ){
			return false;
		}
		$notify = $this->notify;
		
		$bid = $this->app->getModule('tender')->getComponent('bidManager')->getBidInfo($this->parameters['bidId']);
		
		if ( $bid === null ){
			return false;
		}
		
		$this->parameters['mobile'] = $bid->user->mobile;
		$this->sendSms(array(
				'{bid}' => $bid->title,
				'{userName}' => $bid->user->nickname,
				'{bidFailedReason}' => $bid->failed_description
		));
	}
}