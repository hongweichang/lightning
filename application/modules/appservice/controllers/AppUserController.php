<?php
	class AppUserController extends Controller{

		public function filters(){
			return array();
		}

		public function actionIndex(){
			echo "ok";
		}

		public function actionLogin(){
			if($this->app->getUser()->getIsGuest()){
				$account = $this->getPost('account',null);
				$password = $this->getPost('password',null);

				if(!empty($account) && !empty($password)){
					$info  = array(
								'account'=>$account,
								'password'=>$password,
							);

					$login = $this->app->getModule('user')->getComponent('userManager')->login($info);

					if($login === true)
						$this->response(200,'登陆成功','');
					else
						$this->response(400,'登陆失败，用户名或密码错误','');
				}
			}else
				$this->response(401,'登陆失败，请不要重复登陆','');
		
		}


		public function actionLogout(){
			Yii::app()->user->logout();
			$this->response(200,'退出成功','');
		}

	}
?>