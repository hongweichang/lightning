<?php
/**
 * @name AdministratorSelector.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-10 
 * Encoding UTF-8
 */
class AdministratorSelector extends Selector{
	public $nickname;
	public $account;
	
	public function rules(){
		return array(
				array('nickname,account','safe'),
		);
	}
}