<?php
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity{
	const ERROR_USER_LOCKED = 3; // 账户被锁定
	protected $_user;
	
	protected $_stateKeys = array(
			'nickname',
			'email',
			'role',
			'icon',
			'uuid',
			'last_login_time'
	);
	
	public function getId(){
		return $this->_user->getAttribute('id');
	}
	
	public function authenticate(){
		if ( $this->findUser() === false || $this->checkLocked() === true ){
			return false;
		}
		
		$security = Yii::app()->getSecurityManager();
		if ( $security->verifyPassword($this->password,$this->_user->getAttribute('password')) ){
			$this->setPersistentStates($this->_user->getAttributes($this->_stateKeys));
			$this->username = $this->_user->getAttribute('nickname');
			$this->errorCode = self::ERROR_NONE;
			$this->afterLogin();
			return true;
		}else {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
			$this->errorMessage = '密码错误，请重试';
			return false;
		}
	}
	
	public function getUserModel(){
		return $this->_user;
	}
	
	/**
	 * @return boolean
	 */
	protected function checkLocked(){
		if ( $this->_user->getAttribute('locked') == 1 ){
			$this->errorCode = self::ERROR_USER_LOCKED;
			$this->errorMessage = '该帐号被锁定，请与管理员联系';
			return true;
		}else {
			return false;
		}
	}
	
	/**
	 *
	 * @return boolean
	 */
	protected function findUser(){
		$condition = '`email`=:account OR `mobile`=:account';
		$this->_user = FrontUser::model()->with('baseUser')->find($condition,array(':account'=>$this->username));
		
		if ( $this->_user === null ){
			$this->errorCode = self::ERROR_USERNAME_INVALID;
			$this->errorMessage = '用户不存在';
			return false;
		}else {
			return true;
		}
	}
	
	public function afterLogin(){
		$this->_user->attributes = array(
			'last_login_time' => time(),
			'last_login_ip' => Yii::app()->request->getUserHostAddress()
		);
		$this->_user->update();
	}
}