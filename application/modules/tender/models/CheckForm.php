<?php
/**
 * @name CheckForm.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-25 
 * Encoding UTF-8
 */
class CheckForm extends CFormModel{
	public $payPasswd;
	public $payVerify;
	
	public function rules(){
		return array(
				array('payPasswd,payVerify','required','message'=>'请填写{attribute}')
		);
	}
	
	public function attributeLabels(){
		return array(
				'payPasswd' => '支付密码',
				'payVerify' => '手机验证码'
		);
	}
	
	public function run(){
		
	}
}