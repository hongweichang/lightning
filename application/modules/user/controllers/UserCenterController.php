<?php
/*
**用户个人中心
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/

class UserCenterController extends Controller{
	public function filters(){
		return array();
	}

	public function actionIndex(){
		echo "i 'm your center";
	}

	public function actionUserInfo(){
		$uid = Yii::app()->user->id;
		//$uid = 23;
		$userData = $this->app->getModule('user')->getComponent('userManager')->getUserInfo($uid);

		if(isset($_POST['FrontUser'])){
			$attributes = $_POST['FrontUser'];
			$userData->gender = $attributes['gender'];
			$userData->address = $attributes['address'];
			$userData->role = $attributes['role'];
			if($userData->save())
				echo "ok";
			else{
				var_dump($userData->getErrors());
				die();
			}
		}
		if(!empty($userData)){
			$this->render('userInfo',array('userData'=>$userData));
		}
	}


	public function actionUserSecurity(){
		$uid = Yii::app()->user->id;
		//$uid = 23;

		$userData = $this->app->getModule('user')->getComponent('userManager')->getUserInfo($uid);
		if(!empty($userData)){
			$this->render('userSecurity',array('userData'=>$userData));
		}
	}


	public function actionMyLend(){
		$uid = Yii::app()->user->id;
		$uid = 23;
		/*$lendData = $this->app->getModule('tender')->bidManager->getBidMetaList('user_id =:uid',array('uid'=>$uid));
		var_dump($lendData);*/
		$this->render('myLend',array(''));
		
	}
}
?>