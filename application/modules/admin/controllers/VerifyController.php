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
		$userCreditData = array();

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
						$this->redirect($this->createUrl('verify/credit'));

				}elseif($action == 'unpass' && $userData->status != 2){
					$this->redirect($this->createUrl('verify/verifyReasonInput',array('id'=>$id)));
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
				if(isset($_POST['submit'])){
					if(!empty($_POST['FrontCredit']['description'])){

						$model->attributes = $_POST['FrontCredit'];
						$description = $model->description;
						$status =  '2';
						$infoData->status = '2';
						$infoData->description = $description;

						if($infoData->save())
							$this->redirect(Yii::app()->createUrl('adminnogateway/verify/credit'));

					}else
						$this->showMessage('审核原因不得为空','verify/credit');
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
				$userLevel = Yii::app()->getModule('credit')->userCreditManager->getUserCreditLevel($value->getRelated('user')->id);
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
							'level'=>$userLevel

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
					$this->redirect($this->createUrl('verify/bidVerifyList'));
				}
			}elseif($action == 'unpass' ){
				$this->redirect($this->createUrl('verify/bidVerifyReasonInput',array('id'=>$id)));
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
			if(isset($post['submit'])){
				if(!empty($post['BidInfo']['failed_description'])){

					$bidData->failed_description = $post['BidInfo']['failed_description'];
					$bidData->verify_progress = 2;
					if($bidData->save()){
						$this->redirect(Yii::app()->createUrl('adminnogateway/verify/bidVerifyList'));
					}
						
				}else{
					$this->showMessage('审核原因不得为空','verify/bidVerifyList');
				}

			}

			$this->render('bidReason',array('model'=>$bidData));
		}

	}
	

}
?>