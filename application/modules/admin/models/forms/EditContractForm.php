<?php
/**
 * @name EditContractForm.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2014-1-19 
 * Encoding UTF-8
 */
class EditContractForm extends CFormModel{
	public $content;
	
	public function rules(){
		return array(
				array('content','safe')
		);
	}
}