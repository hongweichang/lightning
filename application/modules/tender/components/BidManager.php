<?php
/**
 * @name BidManager.php
 * @author wxweven wxweven@163.com
 * Date 2013-11-27 
 * Encoding UTF-8
 */
class BidManager extends CApplicationComponent{
	public $cookieTimeout = 0;
	
	/**
	 * 根据标段的id,返回标段的详细信息
	 * Enter description here ...
	 * @param $bidId
	 * @return $bidDetail 标段的详细信息
	 */
	public function getBidDetail($bidId) {
		$bidDetail = BidInfo::model(); // 标段信息对应的表
		                               
		$bidDetail = $model->findByPk( $bidId ); // 通过标段id来获取标段信息
		return $bidDetail;//返回标段详细信息
	}
	/**
	 * 
	 * @param array $regInfo
	 * @return boolean|RegisterForm
	 */
	public function register($regInfo,$scenario='reg'){
		$form = new RegisterForm();
		
		if ( $regInfo === null ){
			return $form;
		}
		$form->setScenario($scenario);
		
		$form->attributes = $regInfo;
		if ( $form->validate() ){
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
	
	public function login($info){
		$login = new LoginForm();
		
		if ( $info !== null ){
			$login->attributes = $info;
			if ( $login->rememberMe !== 'on' ){
				$this->cookieTimeout = 0;
			}
			if($login->validate() && $login->run($this->cookieTimeout)){
				return true;
			}
		}
		
		return $login;
	}
	
	public function getUserInfo($id,$criteria,$params){
		$user = FrontUser::model()->with('baseUser')->findByPk($id,$criteria,$params);
	}
}