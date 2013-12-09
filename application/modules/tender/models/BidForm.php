<?php
/**
 * file: BidMetaForm.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-9
 * desc: 
 */
class BidForm extends CFormModel{
	public $title;
	public $sum;
	public $rate;
	public $deadline;
	public $start;
	public $end;
	public $desc;
	
	public function rules()
	{
		$rules = array(
			// name, email, subject and body are required
			array('title, sum, rate, deadline, start, end, desc', 'required','message'=>'请填写{attribute}'),
			// email has to be a valid email address
			array('sum','checkSum'),
			array('rate', 'checkRate'),
			array('deadline', 'checkDeadline'),
			array('start','checkDate'),
			// verifyCode needs to be entered correctly
		);
		return $rules;
	}
	
	public function attributeLabels()
	{
		return array(
			'title' => '标段名字',
			'desc' => '标段介绍',
			'sum' => '借款金额',
			'rate' => '年利率',
			'start' => '招标开始时间',
			'end' => '招标结束时间',
			'deadline' => '标段期限',
		);
	}
	
	public function checkSum($attribute,$params){
		if(!is_numeric($this->sum) || $this->sum < 10000){
			$this->hasErrors('sum') or $this->addError('sum','请填写不小于1万的正整数');
		}
	}
	
	public function checkRate($attribute,$params){
		if(!is_numeric($this->rate) || $this->rate < 5 || $this->rate > 20){
			$this->hasErrors('rate') or $this->addError('rate','年利率范围： 5% - 20% ');
		}
	}
	
	public function checkDeadline($attribute,$params){
		if(!is_numeric($this->deadline) || $this->deadline > 36){
			$this->hasErrors('deadline') or $this->addError('deadline','请填写不大于36的正整数');
		}
	}
	
	public function checkDate($attribute,$params){
		if(strtotime($this->start) < strtotime(date('Y-m-d'))){
			$this->hasErrors('date') or $this->addError('date','请填写正确的招标开始时间');
		}
		if(strtotime($this->end) < strtotime(date('Y-m-d'))){
			$this->hasErrors('date') or $this->addError('date','请填写正确的招标结束时间');
		}
		if(strtotime($this->start) > strtotime($this->end)){
			$this->hasErrors('date') or $this->addError('date','招标开始时间应小于招标结束时间');
		}
	}
	
	public function save(){
		$bidManager = Yii::app()->getModule('tender')->bidManager;
		return $bidManager->raiseBid(
			Yii::app()->user->getId(),
			$this->title,
			$this->desc,
			(int)$this->sum,
			$this->rate,
			strtotime($this->start),
			strtotime($this->end),
			(int)$this->deadline
		);
	}
}