<?php
/**
 * file: RechargeSelector.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-14
 * desc: 
 */
class RechargeSelector extends Selector{
	public $nickname;
	public $realname;
	public $mobile;
	public $bank;
	public $sum;

	public function rules(){
		return array(
				array('nickname,realname,mobile,bank,sum','safe')
		);
	}
}