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

	/*
	*个人信息获取
	*/
	public function actionUserInfo(){
		$uid = Yii::app()->user->id;
		$userData = $this->app->getModule('user')->getComponent('userManager')->getUserInfo($uid);
		$role = $userData->role;
		$creditData= $this->getUserCredit($role);

		
		$model = new FrontCredit();
		$post = $this->getPost();
		var_dump($post);
		//die();
		if(isset($_POST['FrontCredit'])){
			$file=CUploadedFile::getInstance($model,'filename'); 
			var_dump($file);
			die();
		}

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
			$this->render('userInfo',array('userData'=>$userData,'model'=>$model,'creditData'=>$creditData));
		}
	}

	public function getUserCredit($role){
		if(!empty($role)){
			$userCredit = CreditRole::model()->with('verification')->findAll('role =:role',array(':role'=>$role));
			foreach($userCredit as $value){
				$creditSetting[] = array(
						$value->getRelated('verification')
					);
			}
			
			return $creditSetting;
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
		//$uid = 23;
		/*$lendData = $this->app->getModule('tender')->bidManager->getBidMetaList('user_id =:uid',array('uid'=>$uid));
		var_dump($lendData);*/
		$this->render('myLend',array(''));
		
	}

	public function actionMyBorrow(){
		$uid = Yii::app()->user->id;

		$this->render('myBorrow',array(''));
	}
}
?>