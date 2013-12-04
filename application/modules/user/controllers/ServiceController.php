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
			$post = $this->getPost();
			if( $post !== null ){
				$login = $this->getModule()->getComponent('userManager')->login($post);
				if($login === true){
					$this->response(200,'登录成功','');
				}else{
					$this->response(400,'登录失败，用户名或密码错误',$login->getErrors());
				}
			}
		}else
			$this->response(401,'登录失败，请不要重复登录');
		
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
			
			$register = $this->getModule()->getComponent('userManager')->register($post,'appRegister');
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

}
?>