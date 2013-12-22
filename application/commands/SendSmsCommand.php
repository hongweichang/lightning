<?php
/**
 * @name SendSmsCommand.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-18 
 * Encoding UTF-8
 */
class SendSmsCommand extends LightningCommandBase{
	/**
	 * 发送手机短信验证码
	 */
	public function actionVerifyCode($params=''){
		$notify = $this->app->getModule('notify')->getComponent('notifyManager');
		if ( empty($this->parameters['mobile']) || $notify->checkMobileFormat($this->parameters['mobile']) === false ){
			return false;
		}
		
		$codeLifeTime = isset($this->parameters['codeLifeTime']) ? $this->parameters['codeLifeTime'] : 1800;
		$codeLength = isset($this->parameters['codeLength']) ? $this->parameters['codeLength'] : 4;
		
		$code = $notify->setMobileVerifyCode($this->parameters['mobile'],$codeLifeTime,$codeLength);
		$content = $notify->getSettingProviderByEventName($this->eventName)->getData();
		if ( empty($content) ){
			return false;
		}
		$content = $content[0];
		$smsContent = PlaceholderManager::replacePlaceholders($content->content,array(
				'{code}' => $code,
				'{codeLifeTime}' => $codeLifeTime / 60
		));
		
		$notify->sendSms($this->parameters['mobile'],$smsContent);
		return true;
	}
}