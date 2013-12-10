<?php
/**
 * @name AdministratorForm.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-10 
 * Encoding UTF-8
 */
class AdministratorForm extends CFormModel{
	public $model;
	public $nickname;
	public $account;
	public $password;
	
	public function rules(){
		return array(
				array('nickname,account','required','message'=>'请填写{attribute}'),
				array('password','safe')
		);
	}
	
	public function attributeLabels(){
		return array(
				'nickname' => '昵称',
				'account' => '帐号',
				'password' => '密码'
		);
	}
	
	public function save(){
		if ( $this->validate() ){
			$model = new Administrators();
			$attributes = $this->attributes;
			$attributes['user_type'] = 'backend';
			$model->attributes = $attributes;
			if ( $model->validate() ){
				$model->save(false);
				return true;
			}else {
				$this->addErrors($model->getErrors());
			}
		}
		return false;
		
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