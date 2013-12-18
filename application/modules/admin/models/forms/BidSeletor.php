<?php
/**
 * file: BidSeletor.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-14
 * desc: 
 */
class BidSeletor extends Selector{
	public $nickname;
	public $title;
	public $sum;
	public $month_rate;
	public $deadline;
	public $progress;

	public function rules(){
		return array(
				array('nickname,title,sum,month_rate,deadline,progress','safe')
		);
	}
}