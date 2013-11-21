<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class RegisterForm extends CFormModel
{
	public $nickname;
	public $email;
	public $phone;
	public $password;
	public $confirm;
	public $code;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('nickname, email, phone, password, confirm', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
			array('phone', 'checkPhone'),
			array('password','confirmPassword'),
			// verifyCode needs to be entered correctly
			array('code', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}
	
	public function save(){
		$db = new FrontUser();
		$db->attributes = array(
			'nickname' => $this->nickname,
			'email' => $this->email,
			'mobile' => $this->phone,
			'password' => Yii::app()->securityManager->generate($this->password),
		);
		return $db->save();
	}
	
	public function confirmPassword($attribute,$params){
		if(!$this->hasErrors()){
			if($this->password != $this->confirm){
				$this->addError('confirm', '验证密码不正确');
			}
		}
	}
	
	public function checkPhone($attribute,$params){
		if(!$this->hasErrors()){
			if(!preg_match('#^13\d{9}|14[57]\d{8}|15[012356789]\d{8}|18[01256789]\d{8}$#', $this->phone)){
				$this->addError('phone', '请输入正确的手机号码');
			}
		}
	}
}