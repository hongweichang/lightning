<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel{
	public $account;
	public $password;
	public $rememberMe = '';

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that account and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules(){
		return array(
			array('account,password', 'required','message'=>'请填写{attribute}'),
			array('rememberMe','safe')
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels(){
		return array(
			'account' => '账号',
			'password' => '密码'
		);
	}
	
	public function run($duration=0){
		$this->_identity = new UserIdentity($this->account,$this->password);
		if ( $this->_identity->authenticate() ){
			Yii::app()->getUser()->login($this->_identity,$duration);
			return true;
		}else {
			$this->addError('password',$this->_identity->errorMessage);
			return false;
		}
	}
	
	/**
	 * 
	 * @return UserIdentity
	 */
	public function getIdentity(){
		return $this->_identity;
	}
}
