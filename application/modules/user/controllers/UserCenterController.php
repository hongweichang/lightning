<?php
/*
**用户个人中心
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/

class UserCenterController extends Controller{
	public $defaultAction = 'userInfo';
	public $userData;
	public $userBidMoney =0;
	public $userMetaBidMoney=0;
	
	public function filters(){
		$filters = parent::filters();
		$filters[] = 'fetchUserData + userInfo,myLend,myBorrow,userSecurity,userFund,GetCash';
		return $filters;
	}
	
	public function filterFetchUserData($filterChain){
		$uid = $this->app->user->id;
		$this->userData = $this->getModule()->getComponent('userManager')->getUserInfo($uid);
		$this->userBidMoney = BidInfo::model()->sum('sum','user_id =:uid',array('uid'=>$uid))/100;
		$this->userMetaBidMoney = BidMeta::model()->sum('sum','user_id =:uid',array('uid'=>$uid))/100;
		$filterChain->run();
	}
	
	/*
	*个人信息获取
	*/
	public function actionUserInfo(){
		$this->pageTitle = '个人信息';
		$uid = $this->app->user->id;
		$userData = $this->userData;
		$dataId = array();
		$unnecessaryList = array();
		$necessaryList = array();
		$creditList = array();

		$role = $userData['role'];
		$creditData= $this->getUserCredit($role);



		$finishedId = array();
		$finishedData = $this->getFnishedCreditData($uid);
		foreach($finishedData as $i => $value){
			$finishedId[$i] = $value->verification_id;
		}

		if(!empty($creditData)){
			foreach($creditData as $value){
				$finished = $this->finishCreditCheck($value['credit']->id,$finishedId);
				if($finished === false){
					if($value['optional'] == '0'){
						$necessaryList[] = array(
									'id'=>$value['credit']->id,
									'verification_name'=>$value['credit']->verification_name,
									'optional'=>$value['optional'],
									'grade'=>$value['grade'],
									'status'=>'400'									
									);
					}else{
						$unnecessaryList[] = array(
									'id'=>$value['credit']->id,
									'verification_name'=>$value['credit']->verification_name,
									'optional'=>$value['optional'],
									'grade'=>$value['grade'],
									'status'=>'400'
									);
					}

				}else{
					if($value['optional'] == '0'){
						$necessaryList[] = array(
									'id'=>$value['credit']->id,
									'verification_name'=>$value['credit']->verification_name,
									'optional'=>$value['optional'],
									'grade'=>$value['grade'],
									'status'=>$finishedData[$finished]->status								
									);
					}else{
						$unnecessaryList[] = array(
									'id'=>$value['credit']->id,
									'verification_name'=>$value['credit']->verification_name,
									'optional'=>$value['optional'],
									'grade'=>$value['grade'],
									'status'=>$finishedData[$finished]->status
									);
					}
				}
			}

		}

		$necessaryNum = count($necessaryList);
		$unnecessaryNum = count($unnecessaryList);

		$IconUrl = null;

		if(isset($_POST['FrontUser'])){
			$attributes = $_POST['FrontUser'];

			$userData->gender = $attributes['gender'];
			$userData->address = $attributes['address'];
			if(isset($attributes['realname']))
				$userData->realname = $attributes['realname'];

			if(isset($attributes['role']))
				$userData->role = $attributes['role'];
			if(isset($attributes['identity_id']) && !empty($attributes['identity_id']))
				$userData->identity_id = $attributes['identity_id'];

			if($userData->save()){
				Yii::app()->user->setFlash('success','信息修改成功');
				$this->redirect(Yii::app()->createUrl('user/userCenter/userInfo'));
			}else{
				Yii::app()->user->setFlash('error','信息修改失败');
				$this->redirect(Yii::app()->createUrl('user/userCenter/userInfo'));
			}
		}

		$userCreditLevel = $this->app->getModule('credit')->getComponent(
								'userCreditManager')->UserLevelCaculator($userData->credit_grade);
		$IconUrl = $this->user->getState('avatar');
		$loanable = $this->app->getModule('credit')->userCreditManager->UserBidCheck();
		$this->render('userInfo',array(
						'userData'=>$userData,
						'necessaryCreditData'=>$necessaryList,
						'necessaryNum'=>$necessaryNum,
						'unnecessaryCreditData'=>$unnecessaryList,
						'unnecessaryNum'=>$unnecessaryNum,
						'model'=>new FrontCredit(),
						'IconUrl'=>$IconUrl,
						'creditLevel'=>$userCreditLevel,
						'BidSum'=>$this->userBidMoney,
						'loanable'=>$loanable,
						'MetaSum'=>$this->userMetaBidMoney));
		
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
						'credit'=>$value->getRelated('verification'),
						'optional'=>$value->optional,
						'grade'=>$value->grade
					);
			}
			
			return $creditSetting;
		}
	}

	
	/*
	**获取用户等待后台处理的信用项
	*/
	public function getFnishedCreditData($uid){
		if(is_numeric($uid)){
			$finishCredit = array();
			$criteria = new CDbCriteria;

			$criteria->condition = 'user_id =:uid';
			$criteria->params = array(
							':uid'=>$uid
						);
			
			$criteria->order = 'verification_id ASC,submit_time DESC ';
			
			$finishedData = FrontCredit::model()->findAll($criteria);
			return $finishedData;
		}
	}


	/*
	**判断该信用项用户是否已经上传
	*/
	public function finishCreditCheck($id,$creditData){
		if(is_numeric($id) && is_array($creditData)){
			foreach($creditData as $i => $value){
				if($value == $id)
					return $i;
			}
			return false;
		}
	}

	/*
	**添加信用项
	*/
	public function actionVerificationAdd($type){
		if(!empty($type)){
			$uid = $this->app->user->id;
			$role = $this->user->getState('role');
			//$role = $this->getUserRole($uid);
			$criteria = new CDbCriteria;
			$criteria->condition = 'verification_id = '.$type.'';
			$criteria->compare('role',$role);
			$verificationData = CreditRole::model()->with('verification')->findAll($criteria);

			if(empty($verificationData)){
				Yii::app()->user->setFlash('upload_error','该角色无次信用项');
				$this->redirect(Yii::app()->createUrl('user/userCenter/userInfo'));
				exit();
			}
			$post = $this->getPost();

			if(!empty($post)){

				$model = new FrontCredit;
				$file=CUploadedFile::getInstance($model,'filename'); 
				if(empty($file)){
					Yii::app()->user->setFlash('upload_error','请选择附件!');
					$this->redirect(Yii::app()->createUrl('user/userCenter/userInfo'));						
					exit();
				}

				$fileName = $file->getName();
				//$filenameUTF8 = iconv("gb2312","UTF-8",$fileName);
				$fileSize = $file->getSize();
				$fileType = pathinfo($fileName, PATHINFO_EXTENSION);
				//对上传文件类型进行审核
				$TypeVerify = $this->TypeVerify($fileType);

				if($TypeVerify == 400){
					Yii::app()->user->setFlash('upload_error','文件类型不合法');
					$this->redirect(Yii::app()->createUrl('user/userCenter/userInfo'));
					exit();

				}else{
					$uploadDir = dirname(Yii::app()->basePath).DS.$this->app->getPath('creditFile').
					                    $this->app->partition($uid,'creditFile');

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
						$model->content = $newName;
						$model->submit_time = time();
						$model->status = 0;

						$userCredit = FrontCredit::model()->findAll('verification_id =:id AND user_id =:uid',array(':id'=>$type,':uid'=>$uid));
						if(!empty($userCredit)){
							foreach($userCredit as $value)
								$value->delete();
						}

						if($model->save()){
							Yii::app()->user->setFlash('upload_success','上传成功');
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


	/*
	**安全中心
	*/
	public function actionUserSecurity(){
		$this->pageTitle = '安全中心';
		$uid = Yii::app()->user->id;

		$userData = $this->userData;

		if(!empty($userData)){
			$IconUrl = Yii::app()->getModule('user')->userManager->getUserIcon($uid);
			$this->render('userSecurity',array('userData'=>$userData,'IconUrl'=>$IconUrl));
		}
	}

	
	/*
	**投资列表
	*/
	public function actionMyLend(){
		$this->pageTitle = '我的投资';
		$uid = Yii::app()->user->id;
		$MyLend = array();
		$waitingForBuy = array();
		$finished = array();
		$waitingForPay = array();

		$criteria = new CDbCriteria;
		$criteria->alias = "meta";
		$criteria->condition = 'meta.user_id=:uid';
		$criteria->params = array(
				':uid' => $uid
		);

		$LendData = BidMeta::model()->with('bid','user')->findAll($criteria);

		if(!empty($LendData)){
			foreach($LendData as $value){
				$userData = $value->getRelated('user');
				$bidData = $value->getRelated('bid');
				if($value->status == 21){
					if($bidData->verify_progress == 41){
						$finished[] = array(
							'nickname'=>$userData->nickname,
							'bidTitle'=>$bidData->title,
							'rate'=>$bidData->month_rate,
							'sum'=>$value->sum/100,
							'deadline'=>$bidData->deadline,
							'buyTime'=>date('Y:m:d H:i:s',$value->finish_time),									
									);

					}elseif($bidData->verify_progress == 21){
						$waitingForBuy[] = array(
							'nickname'=>$userData->nickname,
							'bidTitle'=>$bidData->title,
							'rate'=>$bidData->month_rate,
							'sum'=>$value->sum/100,
							'deadline'=>$bidData->deadline,
							'buyTime'=>date('Y:m:d H:i:s',$value->finish_time),

						);

					}elseif($bidData->verify_progress == 31){
						$waitingForPay[] = array(
							'nickname'=>$userData->nickname,
							'bidTitle'=>$bidData->title,
							'rate'=>$bidData->month_rate,
							'sum'=>$value->sum/100,
							'deadline'=>$bidData->deadline,
							'buyTime'=>date('Y:m:d H:i:s',$value->finish_time),
										);
					}

				}

			}
			
		}

		$IconUrl = Yii::app()->getModule('user')->userManager->getUserIcon($uid);
		$this->render('myLend',array(
			'waitingForBuy'=>$waitingForBuy,
			'IconUrl'=>$IconUrl,
			'finished'=>$finished
			));
		
	}

	/*
	**我的借款
	*/
	public function actionMyBorrow(){
		$this->pageTitle = '我的借款';
		$uid = Yii::app()->user->id;
		$waitingForPay = array();
		$waitingForBuy = array();
		$finished = array();
		$borrowSum = 0;

		$myBorrowData = $this->app->getModule('tender')->getComponent('bidManager')->getBidList('user_id =:uid',array(
			'uid'=>$uid));
		foreach($myBorrowData as $value){
			if($value->attributes['verify_progress'] == 31){
					$waitingForPay[] = array(
							$value->attributes
						);
					$borrowSum += $value->attributes['sum']/100;

			}elseif($value->attributes['verify_progress'] == 41){
				$finished[] = array(
								$value->attributes
							);

			}else{
				$waitingForBuy[] = array(
									$value->attributes
								);
			}
		}
		$IconUrl = Yii::app()->getModule('user')->userManager->getUserIcon($uid);
		$this->render('myBorrow',array(
									'waitingForPay'=>$waitingForPay,
									'waitingForBuy'=>$waitingForBuy,
									'finished'=>$finished,
									'borrowSum'=>$borrowSum,
									'IconUrl'=>$IconUrl
									));
	}

	/*
	**用户头像上传
	*/
	public function actionIconUpload(){
		if(isset($_FILES['Filedata'])){
			$uid = $this->app->user->id;
			$fileInfo = CUploadedFile::getInstanceByName('Filedata');
			$fileName = $fileInfo->name;
			$fileType =  $fileInfo->getExtensionName();

			$TypeVerify = $this->TypeVerify($fileType);
			if($TypeVerify !== 'image'){
				echo "上传文件不合法!";
				die();
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
					Yii::app()->user->setFlash('success','上传成功');
					$this->user->setState('avatar',$this->app->getPartedUrl('avatar',$uid).$newName);
					$this->redirect(Yii::app()->createUrl('user/userCenter/userInfo'));
				}
			}
		}
	}


	/*
	**用户登录密码修改
	*/
	public function actionPasswordChange(){
		$post = $this->getPost();
		if(!empty($post)){
			$oldPassword = $post['oldPassword'];
			$newPassword = $post['newPassword'];
			$rePassword = $post['rePassword'];

			if($newPassword != $rePassword){
				Yii::app()->user->setFlash('error','新密码和重复密码不对应');
				$this->redirect(Yii::app()->createUrl('user/userCenter/userSecurity'));
				exit();
			}
			$uid = $this->user->id;
			$userData = FrontUser::model()->findByPk($uid);

			$security = Yii::app()->getSecurityManager();
			$passwordVerify = $security->verifyPassword($oldPassword,$userData->password);

			if($passwordVerify != true){
				Yii::app()->user->setFlash('error','密码验证失败');
				$this->redirect(Yii::app()->createUrl('user/userCenter/userSecurity'));
				exit();
			}else{
				$password = $security->generatePassword($newPassword);
				$userData->password = $password;
				if($userData->save()){
					Yii::app()->user->setFlash('success','密码修改成功');
					$this->redirect(Yii::app()->createUrl('user/userCenter/userSecurity'));
				}else
					var_dump($userData->getErrors());
			}	
		}
	}

	/*
	**支付密码设置
	*/
	public function actionPayPasswordCreate(){
		$post = $this->getPost();

		if(!empty($post)){
			$password = $post['password'];
			$rePassword = $post['rePassword'];

			if($password != $rePassword){
				Yii::app()->setFlash('error','密码和重复密码不对应');
				$this->redirect(Yii::app()->createUrl('user/userCenter/userSecurity'));
				exit();
			}

			$uid = $this->user->id;
			$userData = FrontUser::model()->findByPk($uid);

			if(!empty($userData)){
				$security = Yii::app()->getSecurityManager();
				$payPassword = $security->generatePassword($password);//调用加密组建对密码进行加密
				$userData->pay_password = $payPassword;

				if($userData->save()){
					Yii::app()->user->setFlash('success','支付密码设置成功');
					$this->redirect(Yii::app()->createUrl('user/userCenter/userSecurity'));
				}
			}
		}
	}

	/*
	**资金管理
	*/
	public function actionUserFund(){
		$uid = $this->app->user->id;
		
		$userRate = $this->app->getModule('credit')->getComponent('userCreditManager')->UserRateGet($uid);
		$this->pageTitle = '资金管理';
	
		$userData = $this->userData;
		$IconUrl = Yii::app()->getModule('user')->userManager->getUserIcon($uid);
		
		$p2p = $this->app->getModule('pay')->fundManager->getP2pList(array(
			'condition' => '(from_user=:uid OR to_user=:uid) AND `time`>=:t',
			'order' => '`time` DESC',
			'params' => array(
				'uid' => $this->user->getId(),
				't' => mktime(0,0,0) - 2592000,
			)
		));
		
		$this->render('userFund',array(
			'userData'=>$userData,
			'IconUrl'=>$IconUrl,
			'p2p' => new CArrayDataProvider($p2p),
		));
	}
	
	public function actionAjaxFund(){
		$type = $this->getPost('type','p2p');
		$date = $this->getPost('date','1');
		
		if($type == 'p2p'){
			$p2p = $this->app->getModule('pay')->fundManager->getP2pList(array(
				'condition' => '(from_user=:uid OR to_user=:uid) AND `time`>=:t',
				'order' => '`time` DESC',
				'params' => array(
					'uid' => $this->user->getId(),
					't' => mktime(0,0,0) - $date * 2592000,
				)
			));
		}elseif($type == 'withdraw'){
			$p2p = $this->app->getModule('pay')->fundManager->getWithdrawList(array(
				'condition' => 'user_id=:uid AND raise_time>=:t',
				'order' => '`raise_time` DESC',
				'params' => array(
					'uid' => $this->user->getId(),
					't' => mktime(0,0,0) - $date * 2592000,
				)
			));
		}elseif($type == "recharge"){
			$p2p = $this->app->getModule('pay')->fundManager->getPayList(array(
				'condition' => 'user_id=:uid AND `raise_time`>=:t',
				'order' => '`raise_time` DESC',
				'params' => array(
					'uid' => $this->user->getId(),
					't' => mktime(0,0,0) - $date * 2592000,
				)
			));
		}

		$this->renderPartial("_p2p",array(
			'p2p' => new CArrayDataProvider($p2p),
			'view' => "_".$type."List"
		));
	}

	public function actionAjaxReport(){
		$type = $this->getPost('type','p2p');
		$date = $this->getPost('date','1');
	}


	/*
	**获取用户提现利率
	*/
	public function actionPayBackMoney(){
		$post = $this->getPost();
		$uid = $this->app->user->id;
		$payBackData = array();

		if(is_numeric($post['getSum'])){
			$sum = $post['getSum'];
			$userRate = $this->app->getModule('credit')->getComponent('userCreditManager')->UserRateGet($uid);
			if($userRate !==400){
				$userPaySum = $sum * $userRate['on_withdraw'];
				$GetSum = $userPaySum + $sum;

				$payBackData = array(
								'userPaySum'=>$userPaySum,
								'GetSum'=>$GetSum
							);

				$this->response('','',$payBackData);
				
			}

		}
	}

	
	/*
	**用户提现
	*/
	public function actionGetCash(){
		$post = $this->getPost();
		$uid = $this->app->user->id;

		if(!empty($post['sum']) && !empty($post['bank_card']) && !empty($post['pay_password'])){
			$sum = $post['sum'];
			$bank_card = $post['bank_card'];
			$pay_password = $post['pay_password'];
			$security = Yii::app()->getSecurityManager();
			$passwordVerify = $security->verifyPassword($pay_password,$this->userData->pay_password);

			if($passwordVerify !== true){
				Yii::app()->user->setFlash('error','资金密码验证失败');
				$this->redirect(Yii::app()->createUrl('user/userCenter/userFund'));
				exit();
			}

			$type = 'getCash';
			$charge = $this->ChargeCaculator($sum,$uid,$type);
			$balance = $this->userData->balance/100;

			if($charge !== false){
				$SumMoney = $sum+$charge;
				if($SumMoney > $balance){
					Yii::app()->user->setFlash('error','余额不足');
					$this->redirect(Yii::app()->createUrl('user/userCenter/userFund'));
					exit();				
				}

				$chargeSum = $charge;
				$getCash = $this->app->getModule('pay')->fundManager->raiseWithdraw($uid,$sum,$charge);
				if($getCash === true){
					$this->userData->bank = $bank_card;
					$this->userData->save();
					Yii::app()->user->setFlash('success','提交提现申请成功!');
					$this->redirect(Yii::app()->createUrl('user/userCenter/userFund'));

				}
			}


		}
	}

	
	/*
	**手续费计算器
	*/

	public function ChargeCaculator($sum,$uid,$type){
		if(is_numeric($sum) && is_numeric($uid) && !empty($type)){

			if($type === 'getCash'){
				$userRate = $this->app->getModule('credit')->getComponent('userCreditManager')->UserRateGet($uid);
				if($userRate !== 400){
					$userPaySum = $sum * $userRate['on_withdraw'];
					return $userPaySum;
				}			
			}else
				return false;
		}
	}
}
?>