<?php
/*
**用户个人信息审核及标段审核
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/

class VerifyController extends Admin{

	public function filters(){
		return array();
	}

	/*
	**用户信息审核列表
	*/
	public function actionCredit(){
		$this->pageTitle = '信用信息审核';

		$criteria = new CDbCriteria;
		$criteria->select = 'id,user_id,verification_id,file_type,submit_time,status,description';
		$criteria->condition = 'status =:status';
		$criteria->params = array(
							':status'=>'0'
						);
		$criteria->order = 'submit_time DESC';

		$userInfoData = FrontCredit::model()->with('user','creditSetting')->findAll($criteria);
		foreach($userInfoData as $value){
			$userCreditData[] = array(
								'nickname'=>$value->getRelated('user')->attributes['nickname'],
								'realname'=>$value->getRelated('user')->attributes['realname'],
								'mobile'=>$value->getRelated('user')->attributes['mobile'],
								'verification_name'=>$value->getRelated('creditSetting')->attributes['verification_name'],
								'id'=>$value->attributes['id'],
								'submit_time'=>date('Y-m-d H:i:s',$value->attributes['submit_time'])

							);
			
		}
		$this->render('credit',array('userCreditData'=>$userCreditData));

	}

	
	public function actionOutputInfoByExcel(){


		$criteria = new CDbCriteria;
		$criteria ->select = 'id,user_id,verification_id,content,submit_time,status,description';
		$criteria ->order = 'submit_time DESC';

		$userInfoData = FrontCredit::model()->findAll($criteria);
		$dataArray = array();

		if(!empty($userInfoData)){
			foreach($userInfoData as $key=>$value){
				$infoData[$key] = $value->getAttributes();
			}

			foreach ($infoData as $value){
				$dataArray[] = array(
									'0'=>$value['id'],
									'1'=>$value['user_id'],
									'2'=>$value['verification_id'],
									'3'=>$value['content'],
									'4'=>$value['submit_time'],
									'5'=>$value['status'],
								);
			}
			
			
		}

		$titleArray = array(
						'0'=>'项目编号',
						'1'=>'用户Id',
						'2'=>'审核项编号',
						'3'=>'审核项内容',
						'4'=>'提交时间',
						'5'=>'审核状态'
					);
		//var_dump($dataArray);
		//die();
		$output = $this->app->getModule('user')->getComponent('infoDisposeManager')->ExcelOutput($titleArray,$dataArray);
	}

	public function ExcelOutput($title,$data){
		Yii::import('application.extensions.PHPExcel.*');
		spl_autoload_unregister(array('YiiBase','autoload'));
		include dirname(Yii::app()->basePath).'/application/extensions/PHPExcel/PHPExcel.php';
		include dirname(Yii::app()->basePath).'/application/extensions/PHPExcel/PHPExcel/IOFactory.php';
		include dirname(Yii::app()->basePath).'/application/extensions/PHPExcel/PHPExcel/Writer/Excel5.php';
		$excelData = new PHPExcel();

		if(!empty($title) && is_array($title) && !empty($title) && is_array($title)){
			$titleNumber = 1;
			$titleLevel = 'A';

			foreach($title as $value){
				$excelData->getActiveSheet()->setCellValue($titleLevel.$titleNumber,$value);
				$titleLevel++;
			}

		
			foreach($data as $value){
				$titleLevelPointer = 'A';
				$titleNumber++;

				foreach($value as $key){
					$excelData->getActiveSheet()->setCellValue($titleLevelPointer.$titleNumber,$key);
					$titleLevelPointer++;
				}
			
			}
			 

			$OutputFilname = 'excelFile.xls';
			//$objWriter = new PHPExcel_Writer_Excel2007($excelData);
			$objWriter = new PHPExcel_Writer_Excel5($excelData);
			header("Pragma: public");
			header("Expires: 0");
			header('Cache-Control:must-revalidate, post-check=0, pre-check=0');
			header("Content-Type:application/force-download");
			header("Content-Type:application/vnd.ms-execl");
			header("Content-Type:application/octet-stream");
			header("Content-Type:application/download");;
			header('Content-Disposition:attachment;filename='.$OutputFilname.'');
			header("Content-Transfer-Encoding:binary");
			$objWriter->save('php://output');

			spl_autoload_register(array('YiiBase','autoload'));
			
		}
		

	}

	/*
	**用户资料提交
	*/
	public function actionInfoAdd(){
		$model = new FrontCredit();
		
		if(isset($_POST['FrontCredit'])){
			$model->attributes = $_POST['FrontCredit'];
			$model->verification_id = 1;
			$model->submit_time = time();
			$model->status = 0;

			if(isset($_SESSION['typeName']) && isset($_SESSION['url'])){
				$model->file_type = $_SESSION['typeName'];
				$model->content = $_SESSION['url'];
				$_SESSION['typeName'] = null;
				$_SESSION['url'] = null;
			}else{
				$model->file_type = "text";
				$model->content = $_POST['userInfo']->content;
			}

			if($model->save())
				echo "ok";
			else
				var_dump($model->getErrors());
		}
		$this->render('create',array('model'=>$model));

	}


	/*
	**用户附件上传
	*/
	public function actionUpload(){
		$typeArray = array('jpg','png','gif','jpeg','pdf','zip','rar');
		$maxSize = 1024*1024*30; //最大文件大小约为30MB

			if(isset($_FILES['Filedata'])){
				$fileInfo = CUploadedFile::getInstanceByName('Filedata');
				$fileName = $fileInfo->name;
				$fileType =  pathinfo($fileName, PATHINFO_EXTENSION); 

				$uploadDir = dirname(Yii::app()->basePath)."/upload/credit/".$fileType.'/';
				$dateDir = date('Ym')."/";
				$uploadDir = $uploadDir.$dateDir;

				if(!is_dir($uploadDir)){ //若目标目录不存在，则生成该目录
						mkdir($uploadDir,0077,true);
				}
				
				$randName = Tool::getRandName();//获取一个随机名
				$newName = "userInfo".$randName.".".$fileName;//对文件进行重命名
				$saveUrl = $uploadDir.$newName;
				$isUp = $fileInfo->saveAs($saveUrl);//保存上传文件
				if($isUp){
					//获取对应类型
					$typeName = $this->getFileType($fileType);	
					$url = $saveUrl;

					//保存信息到SESSION
					$_SESSION['typeName'] = $typeName;
					$_SESSION['url'] = $saveUrl;

					$backData = array(
						'name'=>$fileName,
						//'thumb'=>Yii::app()->baseUrl.$thumbUrl,
					);
					// 返回json数据给swfupload上传插件
					echo  json_encode($backData);
				}
			}

	}


	/*
	**获取上传文件在数据库中对应的type
	*/
	public function getFileType($fileType){

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
	**附件下载
	*/
	public function actionDownload($id){
		if(!empty($id) && is_numeric($id)){
			$fileData = FrontCredit::model()->findAll('id =:id',array('id'=>$id));
			if($fileData == null){
				Yii::app()->user->setFlash('error','附件不存在');
				$this->redirect(Yii::app()->createUrl('adminnogateway/verify/credit'));
				exit();

			}else{
				$fileUrl = dirname(Yii::app()->basePath).DS.$this->app->getPath('creditFile').
					                    $this->app->partition($fileData[0]->user_id,'creditFile');
				$file = $fileUrl.$fileData[0]->content;	
				$fileType = pathinfo($file, PATHINFO_EXTENSION);//获取文件扩展名
				$fileName = Tool::getRandName().'.'.$fileType;

				if(file_exists($file)){
					yii::app ()->request->sendFile ($fileName,  file_get_contents($file)); 
				}else{
					
					Yii::app()->user->setFlash('error','附件不存在');
					$this->redirect(Yii::app()->createUrl('adminnogateway/verify/credit'));

				}
			}

		}
	}


	/*
	**用户信息审核
	*/
	public function actionCreditVerify($id,$action){
		if(!empty($id) && is_numeric($id) && !empty($action)){
			$userData = FrontCredit::model()->findByPk($id);

			if(!empty($userData)){
				if($action == 'pass' && $userData->status != 1){
						$userData->status = 1;

					if($userData->save())
						$this->redirect(Yii::app()->createUrl('adminnogateway/verify/credit'));

				}elseif($action == 'unpass' && $userData->status != 2){
					$userData->status = 2;

					if($userData->save())
						$this->redirect(Yii::app()->createUrl('adminnogateway/verify/verifyReasonInput',array('id'=>$id)));

				}

			}	
		}

	}


	
	/*
	**审核未通过原因输入
	*/
	public function actionVerifyReasonInput($id){
		if(!empty($id) && is_numeric($id)){
			$infoData = FrontCredit::model()->findByPk($id);

			if(!empty($infoData)){
				$model = $infoData;
				if(isset($_POST['FrontCredit'])){

					$model->attributes = $_POST['FrontCredit'];
					$description = $model->description;
					$infoData->description = $description;

					if($infoData->save())
						$this->redirect(Yii::app()->createUrl('adminnogateway/verify/credit'));

				}

				$this->render('reason',array('model'=>$model));
			}
		}
		
	}

	public function actionGetUserLevel($uid){
		$output = $this->app->getModule('credit')->getComponent('userCreditManager')->getUserCreditLevel($uid);
		echo $output;
	}


/*
**标段审核列表
*/
	public function actionBidVerifyList(){
		$bidList = array();

		$criteria = new CDbCriteria;
		$criteria->condition = 'verify_progress =:progress';
		$criteria->params = array(
						':progress'=>'0'
					);
		$criteria->order = 'pub_time DESC';

		$bidData = BidInfo::model()->with('user')->findAll($criteria);

		if(!empty($bidData)){
			foreach($bidData as $value){
				
				$bidList[] = array(
							'id'=>$value->id,
							'title'=>$value->attributes['title'],
							'description'=>$value->attributes['description'],
							'nickname'=>$value->getRelated('user')->nickname,
							'realname'=>$value->getRelated('user')->realname,
							'mobile'=>$value->getRelated('user')->mobile,
							'sum'=>$value->sum/100,
							'deadline'=>$value->deadline,
							'rate'=>$value->month_rate/100,

						);
			}
			
			$this->render('bidVerifyList',array('bidList'=>$bidList));
		}
	}


/*
**The action of bid verify
*/

	public function actionBidVerify($id,$action){
		if(is_numeric($id) && !empty($action)){

			$bidData = Yii::app()->getModule('tender')->bidManager->getBidInfo($id);
			if($action == 'pass'){
				$bidData->verify_progress = '1';

				if($bidData->save()){
					$this->redirect(Yii::app()->createUrl('adminnogateway/verify/bidVerifyList'));
				}
			}elseif($action == 'unpass' ){
				$bidData->verify_progress = '2';

				if($bidData->save()){
					$this->redirect(Yii::app()->createUrl('adminnogateway/verify/bidVerifyReasonInput',array('id'=>$id)));
				}
			}
		}
	}


/*
**To input the reason why bid unpassed verify
*/

	public function actionBidVerifyReasonInput($id){
		$post = $this->getPost();

		if(is_numeric($id)){

			$bidData = Yii::app()->getModule('tender')->bidManager->getBidInfo($id);
			if(!empty($post)){
				
				$bidData->failed_description = $post['BidInfo']['failed_description'];

				if($bidData->save()){
					$this->redirect(Yii::app()->createUrl('adminnogateway/verify/bidVerifyList'));
				}
			}

			$this->render('bidReason',array('model'=>$bidData));
		}

	}
	

}
?>