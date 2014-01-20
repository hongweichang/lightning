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
			if ( $c->enabled == 1 ){
				$this->notify->sendSms($this->parameters['mobile'],PlaceholderManager::replacePlaceholders($c->content,$placeholders));
			}
		}
	}
	
	protected function findBid(){
		if ( isset($this->parameters['bidId']) === false ){
			return null;
		}
		return $this->app->getModule('tender')->getComponent('bidManager')->getBidInfo($this->parameters['bidId']);
	}
	
	/**
	 * 发送手机短信验证码
	 */
	public function actionVerifyCode($params=''){
		$notify = $this->notify;
		
		$codeLifeTime = isset($this->parameters['codeLifeTime']) ? $this->parameters['codeLifeTime'] : 1800;
		$codeLength = isset($this->parameters['codeLength']) ? $this->parameters['codeLength'] : 4;
		
		$code = $notify->setMobileVerifyCode($this->parameters['mobile'],$codeLifeTime,$codeLength);
		$this->sendSms(array(
				'{code}' => $code,
				'{codeLifeTime}' => $codeLifeTime / 60
		));
		
		return true;
	}
	
	public function actionBidVerifySuccess($params=''){
		$bid = $this->findBid();
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
		$bid = $this->findBid();
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
	
	public function actionCreditVerifySuccess($params=''){
		if ( isset($this->parameters['creditId']) === false ){
			return false;
		}
		$this->app->getModule('credit');
		$credit = FrontCredit::model()->with('creditSetting','user')->findByPk($this->parameters['creditId']);
		if ( $credit === null ){
			return false;
		}
		
		$this->parameters['mobile'] = $credit->user->mobile;
		$this->sendSms(array(
				'{credit}' => $credit->creditSetting->verification_name,
		));
	}
	
	public function actionCreditVerifyFailed($params=''){
		if ( isset($this->parameters['creditId']) === false ){
			return false;
		}
		$this->app->getModule('credit');
		$credit = FrontCredit::model()->with('creditSetting','user')->findByPk($this->parameters['creditId']);
		if ( $credit === null ){
			return false;
		}
		
		$this->parameters['mobile'] = $credit->user->mobile;
		$this->sendSms(array(
				'{credit}' => $credit->creditSetting->verification_name,
				'{creditFailedReason}' => $credit->description
		));
	}
	
	//还款通知
	public function actionRepay($params=''){
		$bid = $this->findBid();
		if ( $bid === null ){
			return false;
		}
		
		$this->parameters['mobile'] = $bid->user->mobile;
		$this->sendSms(array(
				'{bid}' => $bid->title,
				'{dayLeft}' => $this->parameters['dayLeft'],
				'{money}' => $bid->refund
		));
	}
	
	/**
	 * 逾期
	 * 满标
	 * 留标
	 */
	public function actionBidMessage($params=''){
		$bid = $this->findBid();
		if ( $bid === null ){
			return false;
		}
		
		$this->parameters['mobile'] = $bid->user->mobile;
		$this->sendSms(array(
				'{bid}' => $bid->title,
		));
	}
}