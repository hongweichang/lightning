<?php
/**
 * @name ResetPasswordForm.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-28 
 * Encoding UTF-8
 */
class ResetPasswordForm extends CFormModel{
	public $nickname;
	public $mobile;
	public $code;
	public $user;
	
	public function rules(){
		return array(
				array('nickname,mobile,code','required','message'=>'{attribute}不可为空'),
				array('nickname','check')
		);
	}
	
	public function attributeLabels(){
		return array(
				'nickname' => '昵称',
				'mobile' => '手机号码',
				'code' => '验证码'
		);
	}
	
	public function check($attribute,$params){
		if ( empty($this->mobile) ){
			$this->addError('mobile', '手机号码不能为空');
			return false;
		}elseif(!preg_match('#^13\d{9}|14[57]\d{8}|15[012356789]\d{8}|18[01256789]\d{8}$#', $this->mobile)){
			$this->addError('mobile', '手机号码格式不正确');
			return false;
		}else {
			$notify = Yii::app()->getModule('notify')->getComponent('notifyManager');
			if ( $notify->applyMobileCodeVerify($this->mobile,$this->code) === false ){
				$this->addError('code','验证码错误');
				return false;
			}
		}
		
		$criteria = new CDbCriteria();
		$criteria->condition = 'mobile=:mobile AND nickname=:nickname';
		$criteria->params = array(
				':mobile' => $this->mobile,
				':nickname' => $this->nickname
		);
			
		$userManager = Yii::app()->getModule('user')->getComponent('userManager');
		$users = $userManager->findUsers($criteria);
		
		if ( count($users) !== 1 ){
			$this->addError('nickname','昵称和手机号码不匹配');
			return false;
		}
		$this->user = $users[0];
	}
}