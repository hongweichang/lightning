<?php
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity{
	const ERROR_ACCOUNT_INVALID=3; // 账户被锁定
	public $errorMessage = '未知错误';
	
	public function authenticate(){
		$user = FrontUser::model()->find('email=:u',array('u' => $this->username));
		if(empty($user)){
			$user = FrontUser::model()->find('mobile=:m',array('m' => $this->username));
		}
		if(empty($user)){
			$this->errorCode = self::ERROR_USERNAME_INVALID;
			$this->errorMessage = '账号不存在';
		}else{
			if($user->getAttribute('password') != Yii::app()->securityManager->generate($this->password)){
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
				$this->errorMessage = '密码错误';
			}elseif($user->getAttribute('locked')){
				$this->errorCode = self::ERROR_ACCOUNT_INVALID;
				$this->errorMessage = '账号已被锁定';
			}else{
				$this->errorCode = self::ERROR_NONE;
				$this->setPersistentStates($user->getAttributes());
				$this->afterLogin($user);
			}
		}
		return !$this->errorCode;
	}
	
	public function afterLogin($db){
		$db->attributes = array(
			'last_login_time' => time(),
			'last_login_ip' => Yii::app()->request->getUserHostAddress()
		);
		$db->update();
	}
}