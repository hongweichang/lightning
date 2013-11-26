<?php
/*
**用户模块API服务
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/

class ServiceController extends Controller{
	public function filters(){
		return array();
	}

	/**
	*获取用户信用评分接口
	**/
	public function actionGetCreditGrade(){
		$id = $this->getPost('id',null);
		if(!empty($id) && is_numeric($id)){

			$userData = FrontUser::model()->findByPk($id);
			if(!empty($userData)){
				$credit_grade = $userData['attributes']['credit_grade'];
				$userCredit = $userData->credit_grade;
				$this->response(200,'',$credit_grade);
			}else
				$this->response(400,'用户不存在','');
		}
	}

	/*
	**用户反馈及提问添加接口
	*/
	public function actionCreateUserMessage(){
		$uid = $this->getPost('uid',null);
		$title = $this->getPost('title',null);
		$content = $this->getPost('content',null);

		if(is_numeric($uid) && !empty($title) && !empty($content)){
			$messageData = array(
							'user_id'=>$uid,
							'title'=>$title,
							'content'=>$content,
						);
			$messageAdd = $this->app->getModule('user')->getComponent('infoDisposeManager')->UserMessageAdd($messageData);

			if($messageAdd == 200)
				$this->response(200,'添加成功','');
			else
				$this->response(400,'添加失败','');
		}
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
						);

				$login = $this->getModule()->getComponent('userManager')->login($info);

				if($login === true)
					$this->response(200,'登陆成功','');
				else
					$this->response(400,'登陆失败，用户名或密码错误','');
			}
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
		$account = $this->getPost('account',null);
		$email = $this->getPost('email',null);
		$mobile = $this->getPost('mobile',null);
		$password = $this->getPost('password',null);
		$repassword = $this->getPost('repassword',null);

		if(!empty($account) && !empty($email) && !empty($mobile) && !empty($password) && !empty($repassword)){
			$info = array(
						'account'=>$account,
						'email'=>$email,
						'mobile'=>$mobile,
						'password'=>$password,
						'repassword'=>$repassword,
					);
			
			$register = $this->getModule()->getComponent('userManager')->register($info,$scenario='appRegister');
			if($register === true)
				$this->response(200,'注册成功','');
			else
				$this->response(400,'注册失败','');

		}else
			$this->response(401,'信息不完整','');
	}

}
?>