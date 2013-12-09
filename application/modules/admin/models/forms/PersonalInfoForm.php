<?php
/**
 * @name PersonalInfoForm.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-9 
 * Encoding UTF-8
 */
class PersonalInfoForm extends CFormModel{
	public $model;
	public $account;
	public $nickname;
	public $password;
	
	public function rules(){
		return array(
				array('account,nickname','required','message'=>'请填写{attribute}'),
				array('model','safe')
		);
	}
	
	public function save(){
		
	}
	
	public function attributeLabels(){
		return array(
				'account' => '帐号',
				'nickname' => '昵称',
				'password' => '密码'
		);
	}
}