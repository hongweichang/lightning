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
		$filters[] = 'fetchUserData + userInfo,myLend,myBorrow,userSecurity,userFund,GetCash,userRefund';
		return $filters;
	}
	
	public function filterFetchUserData($filterChain){
		$uid = $this->app->user->id;
		$this->userData = $this->getModule()->getComponent('userManager')->getUserInfo($uid);
		$this->userBidMoney = BidInfo::model()->sum('sum','user_id =:uid and (verify_progress=21 or verify_progress=31 or verify_progress=40)',array('uid'=>$uid))/100;
		$this->userMetaBidMoney = BidMeta::model()->sum('sum','user_id =:uid and (status=21 or status=31 or status=40)',array('uid'=>$uid))/100;
		$filterChain->run();
	}
	
	/*
	**用户个人信息
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
		$finishedData = $this->getFnishedCreditData($uid,$role);
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

			/*角色修改*/
			if(isset($attributes['role']) && $attributes['role'] != $userData->role){
				$necessaryNum = '0';
				$unNecessaryGrade = '0';
				$newNecessaryNum = '0';
				$newUnNecessaryGrade = '0';
				$oldRole = $userData->role;
				$newRole = $attributes['role'];
				$userData->role = $newRole;
				$this->user->setState('role',$newRole);

				//计算原角色通过审核的必填信用项目数目
				foreach($necessaryList as $value){
					if($value['status'] == 1)
						$necessaryNum++;
				}

				//计算原角色通过审核的选填信用项目应加总分
				foreach($unnecessaryList as $value){
					if($value['status'] == 1)
						$unNecessaryGrade += $value['grade'];
				}

				$newRoleCreditData = $this->getUserCredit($newRole);
				$newFinishedData = $this->getFnishedCreditData($uid,$newRole);
				$newFinishedId = array();

				foreach($newFinishedData as $i => $value){
					$newFinishedId[$i] = $value->verification_id;
				}

				if(!empty($newRoleCreditData)){

					foreach($newRoleCreditData as $value){
						$finished = $this->finishCreditCheck($value['credit']->id,$newFinishedId);
						if($finished !== false){
							if($value['optional'] == '0'){
								$newNecessaryNum++;
							}elseif($value['optional'] == '1'){
								$newUnNecessaryGrade += $value['grade'];
							}
						}

					}
				}

				$userGrade = $userData->credit_grade;
				$newCreditGrade = $this->roleGradeReset(
					$oldRole,$newRole,$necessaryNum,$unNecessaryGrade,$newNecessaryNum,$newUnNecessaryGrade,$userGrade);

				$userData->credit_grade = $newCreditGrade;
			}

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
	**角色信用积分重置
	*/
	public function roleGradeReset($oldRole,$newRole,$oldfinishedSum,$oldunNecessaryGrade,$newfinishedSum,$newunNecessaryGrade,$userGrade){
		if(!empty($oldRole) && !empty($newRole) && is_numeric($oldfinishedSum) && is_numeric($oldunNecessaryGrade) && is_numeric($userGrade)){
			$oldnecessarySum = CreditRole::model()->count('role =:role AND optional =:optional',array(
								':role'=>$oldRole,
								':optional'=>'0'));

			$newnecessarySum = CreditRole::model()->count('role =:role AND optional =:optional',array(
								':role'=>$newRole,
								':optional'=>'0'));
				

			if($oldfinishedSum == $oldnecessarySum)
				$userGrade -= 60;

			$userGrade -= $oldunNecessaryGrade;

			if($newfinishedSum == $newnecessarySum){
				$userGrade += 60;
			}
			$userGrade += $newunNecessaryGrade;
			
			$creditGrade = $userGrade;
			return $creditGrade;
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
	public function getFnishedCreditData($uid,$role){
		if(is_numeric($uid) && !empty($role)){
			$finishCredit = array();
			$criteria = new CDbCriteria;

			$criteria->condition = 'user_id =:uid AND role =:role';
			$criteria->params = array(
							':uid'=>$uid,
							':role'=>$role
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
	public function actionVerificationAdd(){
		$type = $this->getQuery('type');
		if(!empty($type)){
			$uid = $this->app->user->id;
			$role = $this->user->getState('role');
			//$role = $this->getUserRole($uid);
			$criteria = new CDbCriteria;
			$criteria->condition = 'verification_id = '.$type.'';
			$criteria->compare('role',$role);
			$verificationData = CreditRole::model()->with('verification')->findAll($criteria);

			if(empty($verificationData)){
				Yii::app()->user->setFlash('upload_error','你的角色无次信用项');
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
				$fileTypeName = strtolower($fileType);
				//对上传文件类型进行审核
				$TypeVerify = $this->TypeVerify($fileTypeName);

				if($TypeVerify == 400){
					Yii::app()->user->setFlash('upload_error','文件类型不合法');
					$this->redirect(Yii::app()->createUrl('user/userCenter/userInfo'));
					exit();

				}else{
					$uploadDir = dirname(Yii::app()->basePath).DS.$this->app->getPath('creditFile').
					                    $this->app->partition($uid,'creditFile');

					if(!is_dir($uploadDir)){ //若目标目录不存在，则生成该目录
						mkdir($uploadDir,0775,true);
					}

					$randName = Tool::getRandName();//获取一个随机名
					$newName = "Credit".$randName.".".$fileType;//对文件进行重命名

					$saveUrl = $uploadDir.$newName;
					$isUp = $file->saveAs($saveUrl);//保存上传文件

					if($isUp){
						$model->user_id = Yii::app()->user->id;
						$model->verification_id = $type;
						$model->file_type = $TypeVerify;
						$model->content = $newName;
						$model->submit_time = time();
						$model->status = 0;
						$model->role = $role;

						$userCredit = FrontCredit::model()->findAll('verification_id =:id AND user_id =:uid AND role =:role',array(
							':id'=>$type,
							':uid'=>$uid,
							'role'=>$role));

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
		$waitingForPaySum = 0;
		$inComeSum = 0;
		$inComeSum_month = 0;

		$criteria = new CDbCriteria;
		$criteria->alias = "meta";
		$criteria->condition = 'meta.user_id=:uid';
		$criteria->order = 'buy_time DESC';
		$criteria->params = array(
				':uid' => $uid
		);

		$LendData = BidMeta::model()->with('bid','user')->findAll($criteria);

		if(!empty($LendData)){
			foreach($LendData as $value){
				$userData = $value->getRelated('user');
				$bidData = $value->getRelated('bid');
				$BorrowUser = FrontUser::model()->findByPk($bidData->user_id);

					if($value->status == 41 || $value->status == 30){ //  完成、流标
						$finished[] = array(
							'nickname'=>$BorrowUser->nickname,
							'bidTitle'=>$bidData->title,
							'rate'=>$bidData->month_rate,
							'sum'=>$value->sum/100,
							'deadline'=>$bidData->deadline,
							'buyTime'=>date('Y-m-d H:i:s',$value->buy_time),
							'status' => $value->status								
						);
					}elseif($value->status == 21 || $value->status == 11 || $value->status == 20){ // 未付款、已付款、已取消
						$waitingForBuy[] = array(
							'id'=>$bidData->id,
							'nickname'=>$BorrowUser->nickname,
							'bidTitle'=>$bidData->title,
							'rate'=>$bidData->month_rate,
							'sum'=>$value->sum/100,
							'deadline'=>$bidData->deadline,
							'buyTime'=>date('Y-m-d H:i:s',$value->buy_time),
							'meta_id' => $value->id,
							'status' => $value->status
						);
					}elseif($value->status == 31 || $value->status == 40){  //满标（还款）、逾期
						if($value->status == 31){
							$waitingForPaySum += $value->sum/100;
							$inComeSum_month += $value->refund/100;
							$inComeSum += $value->refund/100 * $bidData->deadline;
						}

						$waitingForPay[] = array(
							'nickname'=>$BorrowUser->nickname,
							'bidTitle'=>$bidData->title,
							'rate'=>$bidData->month_rate,
							'sum'=>$value->sum/100,
							'deadline'=>$bidData->deadline,
							'buyTime'=>date('Y-m-d H:i:s',$value->buy_time),
							'status' => $value->status,
							'repay_deadline' => $bidData->repay_deadline
						);
					}

			}
			
		}

		$IconUrl = Yii::app()->getModule('user')->userManager->getUserIcon($uid);
		$this->render('myLend',array(
			'waitingForBuy'=>$waitingForBuy,
			'waitingForPay'=>$waitingForPay,
			'waitingForPaySum'=>$waitingForPaySum,
			'IconUrl'=>$IconUrl,
			'finished'=>$finished,
			'userMetaBidMoney'=>$this->userMetaBidMoney,
			'inComeSum_month'=>$inComeSum_month,
			'inComeSum'=>$inComeSum

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
		$borrowSum_month = 0;
		$userBidMoney = $this->userBidMoney;

		$myBorrowData = $this->app->getModule('tender')->getComponent('bidManager')->getBidList('user_id =:uid',array(
			'uid'=>$uid));
		foreach($myBorrowData as $value){
			if($value->attributes['verify_progress'] == 31 || $value->attributes['verify_progress'] == 40){ // 满标(还款)、逾期
				if($value->attributes['verify_progress'] == 31){
					$borrowSum_month += $value->refund/100;
				}
				$borrowSum += $value->refund/100;
				$waitingForPay[] = array(
					$value->attributes
				);
			}elseif($value->attributes['verify_progress'] == 41){ //完成(还清)
				$finished[] = array(
					$value->attributes
				);
			}else{
				$waitingForBuy[] = array( //提交待审、未通过、通过招标、流标
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
									'IconUrl'=>$IconUrl,
									'userBidMoney'=>$userBidMoney,
									'borrowSum_month'=>$borrowSum_month
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
				exit();
			}
			$uploadDir = dirname(Yii::app()->basePath).DS.$this->app->getPath('avatar').
					                    $this->app->partition($uid,'avatar');

			if(!is_dir($uploadDir)){ //若目标目录不存在，则生成该目录
				mkdir($uploadDir,0775,true);
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
					$this->user->setState('avatar',$this->app->getPartedUrl('avatar',$uid).$newName);
					$newIcon = array('flag'=>'1','newIconUrl'=>$this->app->getPartedUrl('avatar',$uid).$newName);
					echo json_encode($newIcon);
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
		if(!empty($_POST)){
			$payment = $this->getPost('payment','ips');
			$sum = $this->getPost('sum',0);
			if($sum && is_numeric($sum)){
				$url = $this->app->getModule('pay')->fundManager->pay($payment,$sum);
				$this->redirect($url);
			}
		}
		
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
		$p2p = new CArrayDataProvider($p2p);
		$p2p->pagination = false;
		
		$this->render('userFund',array(
			'userData'=>$userData,
			'IconUrl'=>$IconUrl,
			'p2p' => $p2p,
		));
	}
	
	public function actionRefund(){
		$this->pageTitle = '标段还款';
		
		$bid = $this->app->getModule('tender')->bidManager->getBidInfo($this->getQuery('bid'));
		if(!empty($bid) && $bid->getAttribute('user_id') == $this->app->user->getId()){
			
			if(!empty($_POST)){
				$password = $this->getPost('pay_password');
				$notify = $this->app->getModule('notify')->getComponent('notifyManager');
				//$user = $bid->getRelated('user');
				if ( $this->app->getSecurityManager()->verifyPassword($password,$this->userData->pay_password) === false ){			
					$this->redirect($this->createUrl('userCenter/userRefund',array(
						'bid' => $this->getQuery('bid',81),
						'e' => base64_encode('1资金密码错误')
					)));
				}
				
				if($this->userData->getAttribute('balance') - $bid->getAttribute('refund')){
					if($this->app->getModule('tender')->bidManger->repayBid($bid)){
						$this->render('refundSuccess');
					}else{
						$this->render('refundFail');
					}
				}else{
					$this->render('refundFail');
					//$this->redirect($this->createUrl('userCenter/userFund'));
				}
			}
			
			$this->render('userRefund',array(
				'userData' => $this->userData,
				'bid' => $bid,
			));
		}else{
			$this->render('//common/404');
		}
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
		 //提现
		if(is_numeric($post['getSum'])){
			$sum = $post['getSum'];
			$userRate = $this->app->getModule('credit')->getComponent('userCreditManager')->UserRateGet($uid);
			if($userRate !==400){
				$userPaySum = $sum * $userRate['on_withdraw'];
				$GetSum = $userPaySum + $sum;

				$payBackData = array(
								'userPaySum'=>number_format($userPaySum,2),
								'GetSum'=>number_format($GetSum,2)
							);

				$this->response('','',$payBackData);
				
			}
		}
		//充值
		if(is_numeric($post['paySum'])){
			$sum = $post['paySum'];
			$userRate = $this->app->getModule('credit')->getComponent('userCreditManager')->UserRateGet($uid);
			if($userRate !==400){
				$userPaySum = $sum * $userRate['on_recharge'];
				//$GetSum = $userPaySum + $sum;
			
				$payBackData = array(
					'userPayCharge'=>number_format($userPaySum,2),
					//'GetSum'=>$GetSum
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