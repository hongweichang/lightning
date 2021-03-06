<?php
/**
 * @name UserManager.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-23 
 * Encoding UTF-8
 */
class UserManager extends CApplicationComponent{
	public $cookieTimeout = 0;
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
	
	public function getUserInfo($uid,$condition='',$params=array()){
		return FrontUser::model()->with('baseUser')->findByPk($uid,$condition,$params);
	}

	/*
	**获取用户头像
	*/
	public function getUserIcon($id){
		if(is_numeric($id)){
			$userIcon = FrontUserIcon::model()->findAll('user_id =:uid',array('uid'=>$id));

			if(!empty($userIcon)){
				$userIconName = end($userIcon)->attributes['file_name'];
				return $this->resolveIconUrl($userIconName,$id);
			}else{
				return $this->resolveIconUrl(null);
			}
		}
	}
	
	public function resolveIconUrl($icon=null,$partIn=null){
		$app = Yii::app();
		$url = $app->getPartedUrl('avatar',$partIn);
		if ( $icon === null ){
			return $url.'default.png';
		}else{
			if(!file_exists($app->getPartedPath('avatar',$partIn).$icon)){
				$defaultUrl = $app->getPartedUrl('avatar',null);
				return $defaultUrl.'default.png';
			}
					
		}
		return $url.$icon;
	}
	
	public function findUsers($criteira='',$params=array()){
		return FrontUser::model()->findAll($criteira,$params);
	}
}