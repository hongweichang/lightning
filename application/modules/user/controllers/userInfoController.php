<?php
/*
**用户个人信息处理
design By HJtianling,2507073658@qq.com
2013.11.16
*/

class UserInfoController extends CmsController{

	public function filters(){
		return array();
	}

	/*
	**用户信息资料管理
	*/
	public function actionIndex(){
		$criteria = new CDbCriteria;
		$criteria ->select = 'id,user_id,verification_id,file_type,submit_time,status,description';
		$criteria ->order = 'submit_time DESC';

		$userInfoData = Credit::model()->findAll($criteria);
		$this->render('index',array('userInfo'=>$userInfoData));

	}



	/*
	**用户资料提交
	*/
	public function actionInfoAdd(){
		$model = new Credit();
		
		if(isset($_POST['Credit'])){
			$model->attributes = $_POST['Credit'];
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
			$fileData = Credit::model()->findAll('id =:id',array('id'=>$id));

			if($fileData == null){
				throw new CHttpException ('500', '文件不存在');  
			}else{
				$fileUrl = $fileData[0]->content;
				$fileType = pathinfo($fileUrl, PATHINFO_EXTENSION);//获取文件扩展名
				$fileName = Tool::getRandName().'.'.$fileType;
				
				if(file_exists($fileUrl)){
					yii::app ()->request->sendFile ($fileName,  file_get_contents ($fileUrl)); 
				}
			}

		}
	}


	/*
	**用户信息审核
	*/
	public function actionVerify($id,$action){
		if(!empty($id) && is_numeric($id) && !empty($action)){
			$userData = Credit::model()->findByPk($id);

			if(!empty($userData)){
				if($action = 'pass' && $userData->status != 1){
						$userData->status = 1;

					if($userData->save())
						$this->redirect(Yii::app()->createUrl('user/userInfo/index'));

				}elseif($action = 'unpass' && $userData->status != 2){
					$userData->status = 2;

					if($userData->save())
						$this->redirect(Yii::app()->createUrl('user/userInfo/verifyReasonInput',array('id'=>$id)));

				}

			}	
		}

	}


	
	/*
	**审核未通过原因输入
	*/
	public function actionVerifyReasonInput($id){
		if(!empty($id) && is_numeric($id)){
			$infoData = Credit::model()->findByPk($id);

			if(!empty($infoData)){
				$model = $infoData;
				if(isset($_POST['Credit'])){

					$model->attributes = $_POST['Credit'];
					$description = $model->description;
					$infoData->description = $description;

					if($infoData->save())
						$this->redirect(Yii::app()->createUrl('user/userInfo/index'));

				}

				$this->render('reason',array('model'=>$model));
			}
		}
		
	}

}
?>