<?php
/**
 * @name FrontUserSelector.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-10 
 * Encoding UTF-8
 */
class FrontUserSelector extends Selector{
	public $nickname;
	public $realname;
	public $mobile;
	public $email;
	public $balance;
	
	public function rules(){
		return array(
				array('nickname,realname,mobile,email,balance','safe')
		);
	}
}