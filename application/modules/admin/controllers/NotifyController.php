<?php
/**
 * @name NotifyController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-11 
 * Encoding UTF-8
 */
class NotifyController extends Admin{
	private $_notifyType;
	
	public function actionAddEmail(){
		$this->add('email');
	}
	
	public function actionEditEmail(){
		$this->edit('email');
	}
	
	public function actionEmail(){
		$this->view('email');
	}
	
	public function actionAddSms(){
		$this->addNotifications('短信内容请以 【闪电贷】 结尾');
		$this->add('sms');
	}
	
	public function actionEditSms(){
		$this->addNotifications('短信内容请以 【闪电贷】 结尾');
		$this->edit('sms');
	}
	
	public function actionSms(){
		$this->addNotifications('短信内容请以 【闪电贷】 结尾');
		$this->view('sms');
	}
	
	protected function add($type){
		$form = new NotificationAddForm();
		$data = $this->getPost('NotificationAddForm');
		$redirect = $this->getQuery('redirect',null);
		if ( $data !== null ){
			$form->attributes = $data;
			if ( $form->validate() ){
				$form->save($type);
				if ( empty($redirect) ){
					$redirect = $this->createUrl('notify/'.$type);
				}else {
					$redirect = urldecode($redirect);
				}
				$this->showMessage('添加成功',$redirect,false);
			}
		}
		
		$this->render('add',array('model'=>$form,'type'=>$type,'urlParams'=>array('redirect'=>$redirect)));
	}
	
	protected function edit($type){
		$form = new NotificationForm();
		$data = $this->getPost('NotificationForm');
		$redirect = $this->getQuery('redirect');
		$id = $this->getQuery('id');
		if ( $data !== null ){
			$form->id = $id;
			$form->attributes = $data;
			if ( $form->validate() ){
				$form->update();
				if ( empty($redirect) ){
					$redirect = $this->createUrl('notify/'.$type);
				}else {
					$redirect = urldecode($redirect);
				}
				$this->showMessage('修改成功',$redirect,false);
			}
		}
		$form->loadSetting($id);
		$this->render('edit',array('model'=>$form,'type'=>$type,'urlParams'=>array('id'=>$id,'redirect'=>$redirect)));
	}
	
	protected function view($type){
		$notify = $this->app->getModule('notify')->getComponent('notifyManager');
		$config = array(
				'pagination' => array(
						'pageSize' => 15
				),
		);
		$dataProvider = $notify->getSettingProviderByType($type,$config);
		
		$this->render('view',array('dataProvider' => $dataProvider,'type'=>$type));
	}
	
	public function getFormatPlaceholders($placeholders){
		if ( empty($placeholders) ){
			return '';
		}
		
		$formatString = '<div>支持的占位符<ul>';
		foreach ( $placeholders as $name => $placeholder ){
			$formatString .= "<li>{$name}：{$placeholder}</li>";
		}
		$formatString .= '</ul></div>';
		return $formatString;
	}
}