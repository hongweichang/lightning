<?php
/**
 * @name AccountController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-9 
 * Encoding UTF-8
 */
class AccountController extends Admin{
	public function noneLoginRequired(){
		return 'login';
	}
	
	public function actionLogin(){
		if ( $this->user->getIsGuest() === false ){
			$this->redirect($this->createUrl('index/index'));
		}
		$this->layout = false;
		
		$model = new SddLoginForm();
		$post = $this->getPost('SddLoginForm');
		
		if ( $post !== null ){
			$model->attributes = $post;
			if ( $model->login() ){
				$this->redirect($this->createUrl('index/index'));
			}
		}
		$this->pageTitle = '登录';
		$model->password = '';
		$this->render('login',array('model'=>$model));
	}
	
	public function actionLogout(){
		$this->user->logout();
		$this->redirect($this->createUrl('account/login'));
	}
}