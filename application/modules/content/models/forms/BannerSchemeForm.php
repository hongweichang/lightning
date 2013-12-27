<?php
/**
 * @name BannerSchemeForm.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-13 
 * Encoding UTF-8
 */
class BannerSchemeForm extends CFormModel{
	public $scheme_name;
	public $file_titles;
	public $files;
	public $redirect_urls;
	public $description;
	public $banner_type;
	
	public function rules(){
		return array(
				array('scheme_name','required','message'=>'请填写{attribute}'),
				array('files','notEmpty',),
				array('files','check'),
				array('banner_type,file_titles,redirect_urls,description','safe')
		);
	}
	
	public function attributeLabels(){
		return array(
				'scheme_name' => 'banner方案名称',
				'file_names' => 'banner文件',//BannerScheme中的file_names
		);
	}
	
	public function notEmpty(){
		$files = CUploadedFile::getInstances($this,'files');
		if ( empty($files) ){
			$this->addError('files','请上传banner图片');
			return false;
		}
	}
	
	public function check(){
		$files = CUploadedFile::getInstances($this,'files');
		$allowType = array(
				'jpg' => true,
				'jpeg' => true,
				'gif' => true,
				'png' => true,
				'bmp' => true
		);
		foreach ( $files as $file ){
			if ( !array_key_exists($file->getExtensionName(),$allowType) ){
				$this->addError('file','图片格式不正确');
				break;
			}
		}
		
		if ( $this->banner_type == 1 ){//app端不需要设置跳转地址
			$this->redirect_urls = array('#');
		}
	}
	
	public function save(){
		$model = new BannerScheme();
		$files = CUploadedFile::getInstances($this,'files');
		$fileNames = array();
		$now = time();
		
		$pathName = $this->banner_type == 1 ? 'appBanner' : 'siteBanner';
		$savePath = Yii::app()->getPartedPath($pathName,$now);
		$saveFiles = array();
		
		if ( !is_dir($savePath) ){
			mkdir($savePath);
		}
		
		/**
		 * 如果该文件没有超链接，则跳过，文件不保存
		 * 
		 */
		foreach ( $files as $count => $file ){
			if ( !isset($this->redirect_urls[$count]) || empty($this->redirect_urls[$count])){
				continue;
			}
			
			$redirect = $this->redirect_urls[$count];
			if ( 0 !== strncmp($redirect,'http://',7) && 0 !== strncmp($redirect,'https://',8) ){
				$redirect = 'http://'.$redirect;
			}
			
			if ( !empty($this->file_titles[$count]) ){
				$fileTitle = $this->file_titles[$count];
			}else {
				$fileTitle = 'banner';
			}
			
			$saveName = md5($file->getName().$file->getTempName().$file->getSize().microtime(true)).'.'.$file->getExtensionName();
			$fileNames[] = array(
					'title' => $fileTitle,
					'filename' => $saveName,
					'redirect' => $redirect
			);
			$saveFiles[] = array(
					'instance' => $file,
					'saveName' => $savePath.$saveName
			);
		}
		
		$model->attributes = array(
				'scheme_name' => $this->scheme_name,
				'file_names' => json_encode($fileNames),
				'description' => $this->description,
				'add_time' => $now,
				'banner_type' => $this->banner_type
		);
		if ( $model->save() ){
			foreach ( $saveFiles as $saveFile ){
				$saveFile['instance']->saveAs($saveFile['saveName']);
				$image = Yii::app()->image->load($saveFile['saveName']);
				if ( $this->banner_type == 1 ){//app
					$image->resize(2000,400,Image::NONE)->quality(85)->save($saveFile['saveName']);
				}elseif ( $this->banner_type == 0 ) {
					//$image->resize(2000,400,Image::NONE)->quality(85)->save($saveFile['saveName']);
				}
				
			}
			return true;
		}else {
			$this->addErrors($model->getErrors());
		}
	}
}