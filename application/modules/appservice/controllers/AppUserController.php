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
					$userIcon = $this->app->getModule('user')->userManager->getUserIcon($uid);
					$attributes = $userData->attributes;
					/*将部分用户信息提供给app*/
					$userInfo = array(
								'uid' => $attributes['id'],
								'nickname'=>$attributes['nickname'],
								'email' => $attributes['email'],
								'mobile' => $attributes['mobile'],
								'sex' => $attributes['gender'],
								'balance' => $attributes['balance'],
								'realName' => $attributes['realname'],
								'age' => $attributes['age'],
								'userIcon'=>$userIcon
							);
					$this->response(200,'登陆成功',$userInfo);
				}else
					$this->response(400,'登陆失败，用户名或密码错误',$login->getErrors());
					
			}else
				$this->response(402,'登录失败,信息不完整','');
				
			
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
			$userCredit = array();

			$userLevel = $this->app->getModule('credit')->getComponent('userCreditManager')->getUserCreditLevel($uid);
			$userCreditData = FrontCredit::model()->with('creditSetting')->findAll('user_id =:uid',array('uid'=>$uid));
			if(!empty($userCreditData)){

				$userCredit = array(
								'userLevel'=>$userLevel,

							);
			}
			if($userLevel !== null)
				$this->response(200,'获取成功',$userLevel);
			else
				$this->response(400,'获取失败，该用户不存在或其他错误','');
		}
		

	}


	
	/*
	**用户余额查询接口
	*/
	public function actionGetBalance(){
		$uid = $this->user->id;
		$userInfo = FrontUser::model()->findByPk($uid);

		if(!empty($userInfo)){
			$userBalance = $userInfo->balance/100;
			$this->response(200,'查询成功',$userBalance);
		}else
			$this->response(400,'查询失败,用户不存在','');
		
	}

	
	/*
	**用户反馈信息提交接口
	*/
	public function actionCreateUserMessage(){
		$uid = $this->user->id;
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
	**用户头像上传接口
	*/
	public function actionCreateUserIcon(){
		$uid = $this->user->id;

		$model = new FrontUserIcon();
		$fileInfo = CUploadedFile::getInstanceByName('Filedata');
		$fileName = $fileInfo->name;
		$fileType =  $fileInfo->getExtensionName();
		$TypeVerify = $this->TypeVerify($fileType);

		if($TypeVerify !== 'image'){
			$this->response('400','文件格式不合法','');
			exit();
		}

		$uploadDir = dirname(Yii::app()->basePath).DS.$this->app->getPath('avatar').
					           		 $this->app->partition($uid,'avatar');
		if(!is_dir($uploadDir)){ //若目标目录不存在，则生成该目录
			mkdir($uploadDir,0077,true);
		}

		$randName = Tool::getRandName();//获取一个随机名
		$newName = md5('userIcon'.$randName.$fileName).'.'.$fileType;//对文件进行重命名
		$saveUrl = $uploadDir.$newName;
		$isUp = $fileInfo->saveAs($saveUrl);//保存上传文件

		if($isUp){
			$thumbUrl = Tool::getThumb($saveUrl,300,300,$saveUrl);//制作缩略图并放回缩略图存储路径

			$Icon = new FrontUserIcon();
				$Icon->user_id = $uid;
				$Icon->file_name = $newName;
				$Icon->size = '300*300';
				$Icon->file_size = $fileInfo->size;
				$Icon->in_using = 1;

				FrontUserIcon::model()->updateAll(array('in_using'=>0),'user_id=:uid',array(':uid'=>$uid));
				if($Icon->save()){
					$this->response('200','上传成功','');
				}else
					$this->response('401','保存失败，发生错误',$Icon->getErrors());
		}						

	}

	/*
	**头像类型审核
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

	
	/*
	**获取用户信用资料
	*/
	public function actionGetUserCredit(){
		$post = $this->getPost();

		if(is_numeric($post['id'])){
			$uid = $post['id'];
			$CreditList = array();

			$criteria = new CDbCriteria;
			$criteria->condition = 'user_id =:uid AND status =:status';
			$criteria->params = array(
									':uid'=>$uid,
									':status'=>'1'
								);
			$userCredit = FrontCredit::model()->with('creditSetting')->findAll($criteria);

			if(!empty($userCredit)){
				foreach($userCredit as $value){
					$CreditList[] = array(
									'verification_name'=>$value->getRelated('creditSetting')->verification_name,
								);
				}
				$this->response('200','查询成功',$CreditList);
			}else
				$this->response('200','查询成功,该用户尚未上传任何信息');

		}else
			$this->response('400','查询失败,参数错误');
	}

}
?>