<?php
/*
**用户模块API服务
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/

class AppUserController extends Controller{

	public function filters(){
		return array();
	}

	public function actionIndex(){
		echo "ok";
	}

	/*
	**用户登陆接口
	*/
	public function actionLogin(){
		if($this->app->getUser()->getIsGuest()){
			$account = $this->getPost('account',null);
			$password = $this->getPost('password',null);

			if(!empty($account) && !empty($password)){
				$info  = array(
							'account'=>$account,
							'password'=>$password,
							'rememberMe' => 'on'
						);

				$login = $this->app->getModule('user')->getComponent('userManager')->login($info);

				if($login === true){
					$uid = Yii::app()->user->id;
					$userData = $this->app->getModule('user')->getComponent('userManager')->getUserInfo($uid);
					$attributes = $userData->attributes;
					/*将部分用户信息提供给app*/
					$userInfo = array(
								'uid' => $attributes['id'],
								'email' => $attributes['email'],
								'mobile' => $attributes['mobile'],
								'sex' => $attributes['gender'],
								'balance' => $attributes['balance'],
								'realName' => $attributes['realname'],
								'age' => $attributes['age']
							);
					$this->response(200,'登陆成功',$userInfo);
				}
					
			}
				else
					$this->response(400,'登陆失败，用户名或密码错误','');
			
		}else
			$this->response(401,'登陆失败，请不要重复登陆','');
		
	}


	/*
	**用户退出接口
	*/
	public function actionLogout(){
		Yii::app()->user->logout();
		$this->response(200,'退出成功','');
	}


	/*
	**用户注册接口
	*/
	public function actionRegister(){
		$post = $this->getPost();
		
		if( $post !== null ){
			$userManager = $this->app->getModule('user')->getComponent('userManager');
			$register = $userManager->register($post,'appRegister');
			if($register === true){
				$userManager->login(array(
						'account' => $post['email'],
						'password' => $post['password'],
						'rememberMe' => 'on'
				));
				$this->response(200,'注册成功','');
			}else{
				$this->response(400,'注册失败',$register->getErrors());
			}

		}else
			$this->response(401,'信息不完整','');
	}


	/*
	**用户信用级别查询接口
	*/
	public function actionGetCreditGrade(){
		$post = $this->getPost();
		if(!empty($post['uid'])){
			$uid = $post['uid'];
			$userLevel = $this->app->getModule('credit')->getComponent('userCreditManager')->getUserCreditLevel($uid);

			if($userLevel !== null)
				$this->response(200,'获取成功',$userLevel);
			else
				$this->response(400,'获取失败，该用户不存在或其他错误','');
		}
		

	}

}
?>