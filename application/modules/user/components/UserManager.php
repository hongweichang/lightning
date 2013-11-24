<?php
/**
 * @name UserManager.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-23 
 * Encoding UTF-8
 */
class UserManager extends CApplicationComponent{
	/**
	 * 
	 * @param array $regInfo
	 * @return boolean|RegisterForm
	 */
	public function register($regInfo){
		$form = new RegisterForm();
		
		if ( $regInfo !== array() ){
			$form->attributes = $regInfo;
			$result = $form->save();
			if ( $result === true ){
				return true;
			}else {
				foreach ( $result->getErrors() as $attribute => $errors ){
					foreach ( $errors as $error ){
						$form->addError($attribute, $error);
					}
				}
			}
		}
		
		return $form;
	}
	
	public function login(){
		echo "ok";
		
	}
}