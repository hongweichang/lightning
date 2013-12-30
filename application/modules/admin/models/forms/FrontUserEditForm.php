<?php
/**
 * @name FrontUserEditForm.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-31 
 * Encoding UTF-8
 */
class FrontUserEditForm extends CFormModel{
	public $id;
	public $realname;
	public $nickname;
	public $password;
	public $mobile;
	public $email;
	public $identity_id;
	
	public function rules(){
		return array(
				array('realname,nickname,mobile,email,identity_id','required','message'=>'请填写{attribute}'),
				array('id','check')
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
	
	public function check(){
		$model = Yii::app()->getModule('user')->getComponent('userManager')->getUserInfo($this->id);
		if ( $model !== null ){
			$this->attributes = $model->attributes;
		}else {
			$this->addError('id','用户不存在');
		}
	}
	
	public function save(){
		$userManager = Yii::app()->getModule('user')->getComponent('userManager');
	}
}