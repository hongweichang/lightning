<?php
/*
**用户个人信息处理
design By HJtianling,hjtl1992robin@gmail.com
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
				//var_dump($fileInfo);
				//die($fileInfo->type);
				$fileName = $fileInfo->name;
				$fileType =  pathinfo($fileName, PATHINFO_EXTENSION); 
				//die($fileType);
				//$thumbDir = dirname(Yii::app()->basePath)."/upload/ad_pic/thumbs/";
				$uploadDir = dirname(Yii::app()->basePath)."/upload/";
				$dateDir = date('Ym')."/";
				$uploadDir = $uploadDir.$dateDir;
				//$thumbDir = $thumbDir.$dateDir;
				if(!is_dir($uploadDir)){
						mkdir($uploadDir,0077,true);
				}
				/*if(!is_dir($thumbDir)){
					mkdir($thumbDir,0077,true);
				}*/
				
				$randName = Tool::getRandName();//获取一个随机名
				$newName = "userInfo".$randName.".".$fileName;//对文件进行重命名
				$saveUrl = $uploadDir.$newName;
				$picUrl = "/upload/ad_pic/pics/".$dateDir.$newName;
				$isUp = $fileInfo->saveAs($saveUrl);//保存上传文件
				if($isUp){
					echo "ok";
					die();
					/*$thumbName = "thumbs".$randName.".".$picType;
					$saveThumb = $thumbDir.$thumbName;
					$thumbUrl = Tool::getThumb($saveUrl,300,300,$saveThumb);//制作缩略图并放回缩略图存储路径
					$thumbUrl = str_replace(dirname(Yii::app()->basePath),"",$thumbUrl);*/
					
					//保存信息到数据库
					$model = new AdvertisePic;
					$model->url = $picUrl;
					$model->description = $picName;
					$model->thumb_url = $thumbUrl;
					$model->save();
					$id = $model->attributes['id'];
					$_SESSION['pid'] = $id;
					$backData = array(
						'pid'=>$id,
						'thumb'=>Yii::app()->baseUrl.$thumbUrl,
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
}
?>