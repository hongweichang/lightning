<?php
/**
 * @name SddLoginForm.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-9-16
 * Encoding UTF-8
 */
class SddLoginForm extends CFormModel{
	public $account;
	public $password;
	
	public function rules(){
		return array(
				array('account,password','required','message'=>'请填写{attribute}'),
		);
	}
	
	public function attributeLabels(){
		return array(
				'account' => '账号',
				'password' => '密码',
		);
	}
	
	/**
	 * @return boolean
	 */
	public function login($duration=0){
		if ( $this->validate() ){
			$identity = new AdminIdentity($this->account,$this->password);
			if ( $identity->authenticate() ){
				Yii::app()->getUser()->login($identity,$duration);
				return true;
			}else {
				$this->addError('password',$identity->errorMessage);
				return false;
			}
		}else {
			return false;
		}
	}
}