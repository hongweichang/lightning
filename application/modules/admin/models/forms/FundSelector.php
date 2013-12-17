<?php
/**
 * file: FundSelector.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-14
 * desc: 
 */
class FundSelector extends Selector{
	public $from;
	public $to;
	public $sum;

	public function rules(){
		return array(
				array('nickname,realname,mobile,bank,sum','safe')
		);
	}
}