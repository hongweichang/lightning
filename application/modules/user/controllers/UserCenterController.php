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
		$role = $userData['role'];
		$creditData= $this->getUserCredit($role);

		$model = new FrontCredit();

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
			$this->render('userInfo',array('userData'=>$userData,'creditData'=>$creditData,'model'=>$model));
		}
	}

	/*
	**查询用户角色
	*/
	public function getUserRole($id){
		if(is_numeric($id)){
			$userData = $this->app->getModule('user')->getComponent('userManager')->getUserInfo($id);
			$role = $userData['role'];
			return $role;
		}
	}

	/*
	**获取用户信用信息
	*/
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

	/*
	**添加信用项
	*/
	public function actionVerificationAdd($type){
		if(!empty($type)){
			$uid = Yii::app()->user->id;
			$role = $this->getUserRole($uid);
			$criteria = new CDbCriteria;
			$criteria->condition = 'verification_id = '.$type.'';
			$criteria->compare('role',$role);
			$verificationData = CreditRole::model()->with('verification')->findAll($criteria);

			if(empty($verificationData)){
				echo "用户角色与信用项目不符合";
				die();
			}
			$post = $this->getPost();

			if(!empty($post)){

				$model = new FrontCredit;
				$file=CUploadedFile::getInstance($model,'filename'); 

				$fileName = $file->getName();
				$fileSize = $file->getSize();
				$fileType = pathinfo($fileName, PATHINFO_EXTENSION);
				//对上传文件类型进行审核
				$TypeVerify = $this->TypeVerify($fileType);

				if($TypeVerify == 400){
					echo "文件不合法";
					die();
				}else{
					$uploadDir = dirname(Yii::app()->basePath)."/upload/credit/".$fileType.'/';
					$dateDir = date('Ym')."/";
					$uploadDir = $uploadDir.$dateDir;

					if(!is_dir($uploadDir)){ //若目标目录不存在，则生成该目录
						mkdir($uploadDir,0077,true);
					}

					$randName = Tool::getRandName();//获取一个随机名
					$newName = "Credit".$randName.".".$fileName;//对文件进行重命名
					$saveUrl = $uploadDir.$newName;
					$isUp = $file->saveAs($saveUrl);//保存上传文件

					if($isUp){
						$model->user_id = Yii::app()->user->id;
						$model->verification_id = $type;
						$model->file_type = $TypeVerify;
						$model->content = $saveUrl;
						$model->submit_time = time();
						$model->status = 0;

						if($model->save()){
							Yii::app()->user->setFlash('success','上传成功');
							//echo Yii::app()->user->getFlash('success');
							$this->redirect(Yii::app()->createUrl('user/userCenter/userInfo'));

						}
						else
							var_dump($model->getErrors());
					}
				}
				


			}
		}
	}


	/*
	**验证附件类型
	*/
	public function TypeVerify($fileType){

		if(isset($fileType) && !empty($fileType)){
			$map = array(
					'file'=>array('pdf','zip','rar'),
					'image'=>array('jpg','jpeg','png','gif')
				);

			foreach($map as $type=>$typeData){
				foreach($typeData as $key=> $value){
					if(preg_match('/'.$value.'/',$fileType)){
						return $type; 
					}
				}
				
			}
			return 400;
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
		$myBorrowData = $this->app->getModule('tender')->getComponent('bidManager')->getBidList('user_id =:uid',array(
			'uid'=>$uid));
		foreach($myBorrowData as $value){

		}
		$this->render('myBorrow',array(''));
	}

	/*
	**用户头像上传
	*/
	public function actionIconUpload(){
		if(isset($_FILES['Filedata'])){
			$fileInfo = CUploadedFile::getInstanceByName('Filedata');
			$fileName = $fileInfo->name;
			$fileType =  pathinfo($fileName, PATHINFO_EXTENSION); 
		}
	}
}
?>