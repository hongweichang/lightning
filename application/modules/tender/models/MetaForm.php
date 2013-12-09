<?php
/**
 * file: MetaForm.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-9
 * desc: 
 */
class MetaForm extends CFormModel{
	public $bid;
	public $sum;
	public $code;
	public $protocal;
	
	public function rules(){
		$rules = array(
			// name, email, subject and body are required
			array('bid, sum, code, protocal', 'required','message'=>'请填写{attribute}'),
			// email has to be a valid email address
			array('sum','checkSum'),
			'captcha' => array('code', 'captcha' ,'allowEmpty'=>!CCaptcha::checkRequirements(),'message'=>'验证码错误'),
			'protocal' => array('protocal','confirm','message'=>'请同意网站服务协议'),
			// verifyCode needs to be entered correctly
		);
		return $rules;
	}
	
	public function attributeLabels(){
		return array(
			'title' => '投资金额',
			'code' => '验证码',
			'protocal' => '协议书',
		);
	}
	
	public function checkSum($attribute,$params){
		if(!is_numeric($this->sum)){
			$this->hasErrors('sum') or $this->addError('sum','请填写正整数金额');
		}
	}
	
	public function confirm($attribute,$params){
		if ($this->protocal !== 'on'){
			$this->hasErrors('protocal') or $this->addError('protocal',$params['message']);
		}
	}
	
	public function save(){
		$bidManager = Yii::app()->getModule('tender')->bidManager;
		return $bidManager->purchaseBid(Yii::app()->user->getId(),$this->bid,$this->sum);
	}
}