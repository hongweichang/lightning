<?php
/**
 * @name FrontUserEditForm.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-31 
 * Encoding UTF-8
 */
class FrontUserEditForm extends CFormModel{
	public $realname;
	public $nickname;
	public $password;
	public $mobile;
	public $email;
	public $identity_id;
	public $model;
	
	public function rules(){
		return array(
				array('realname,nickname,mobile,email,identity_id','required','message'=>'请填写{attribute}'),
				array('email', 'email','message'=>'{attribute}格式不正确'),
				array('mobile', 'checkmobile'),
				array('model,password','safe')
		);
	}
	
	public function attributeLabels(){
		return array(
				'nickname' => '昵称',
				'realname' => '姓名',
				'mobile' => '手机号码',
				'email' => '邮箱',
				'identity_id' => '身份证号'
		);
	}
	
	public function checkmobile($attribute,$params){
		if(!$this->hasErrors()){
			if(!preg_match('#^13\d{9}|14[57]\d{8}|15[012356789]\d{8}|18[01256789]\d{8}$#', $this->mobile)){
				$this->addError('mobile', '手机号码格式不正确');
			}
		}
	}
	
	public function update(){
		$attributes = $this->attributes;
		if ( isset($attributes['password']) && empty($attributes['password']) ){
			unset($attributes['password']);
		}
		
		$this->model->attributes = $attributes;
		if ( $this->validate() === false ){
			return false;
		}
		
		if ( $this->model->validate() ){
			if ( isset($attributes['password']) ){
				$this->model->setPassword($attributes['password']);
			}
			$this->model->save(false);
			return true;
		}else {
			$this->addErrors($this->model->getErrors());
			return false;
		}
	}
}