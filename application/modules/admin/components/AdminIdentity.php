<?php
/**
 * @name AdminIdentity.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-9 
 * Encoding UTF-8
 */
class AdminIdentity extends CUserIdentity{
	public $id;
	public function authenticate(){
		$condition = '`account`=:account';
		$user = Administrators::model()->with('baseUser')->find($condition,array(':account'=>$this->username));
	
		if ( $user === null ){
			$this->errorCode = self::ERROR_USERNAME_INVALID;
			$this->errorMessage = '管理员不存在';
			return false;
		}
	
		$security = Yii::app()->getSecurityManager();
		if ( $security->verifyPassword($this->password,$user->getAttribute('password')) ){
			$states = array('nickname','account','last_login_time','last_login_ip');
				
			$this->setPersistentStates($user->getAttributes($states));
			$this->username = $user->getAttribute('nickname');
			$this->id = $user->getAttribute('id');
			$this->errorCode = self::ERROR_NONE;
			return true;
		}else {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
			$this->errorMessage = '密码错误';
			return false;
		}
	}
	
	public function getId(){
		return $this->id;
	}
}