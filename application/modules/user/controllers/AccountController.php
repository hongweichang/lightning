<?php
/**
 * @name AccountController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-23 
 * Encoding UTF-8
 */
class AccountController extends Controller{
	public $layout='//layouts/login';
	public $defaultAction = 'login';
	
	public function noneLoginRequired(){
		return 'register,login,sendRegisterVerify,loginTransit,resetPassword,resetPasswordVerify,sendResetVerify';
	}
	
	public function actionLoginTransit(){
		$redirect = $this->getQuery('redirect',null);
		if ( $redirect === null ){
			$redirect = $this->request->urlReferrer;
		}else {
			$redirect = urldecode($redirect);
		}
		
		$this->redirect($this->createUrl('account/login',array('redirect'=>urlencode($redirect))));
	}
	
	public function actionRegister(){
		if ( $this->user->getIsGuest() === false ){
			$this->redirect($this->createUrl('/site'));
		}
		
		$post = $this->getPost('Register');
		$userManager = $this->getModule()->getComponent('userManager');
		
		$form = $userManager->register($post);
		
		if ( $form === true ){
			$userManager->login(array(
					'account' => $post['email'],
					'password' => $post['password'],
					'rememberMe' => 'on'
			));
			$this->redirect($this->createUrl('/site'));
		}
		
		$this->render('layout',array(
			'model' => $form,
			'isLogin' => false,
			'form' => 'register',
		));
	}
	
	public function actionLogin(){
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('/site')));
		if ( $this->user->getIsGuest() === false ){
			$this->redirect($redirect);
		}
		
		$post = $this->getPost('Login');
		$userManager = $this->getModule()->getComponent('userManager');
		
		$form = $userManager->login($post);
		if ( $form === true ){
			//$this->redirect($this->createUrl('/site'));
			$this->redirect($redirect);
		}
		
		$this->render('layout',array(
				'model' => $form,
				'isLogin' => true,
				'form' => 'login',
				'redirect' => urlencode($redirect)
		));
	}
	
	public function actionLogout(){
		Yii::app()->user->logout();
		$this->redirect($this->createUrl('/site'));
	}
	
	//注册验证码
	public function actionSendRegisterVerify(){
		$mobile = $this->getQuery('mobile');
		if ( $mobile === null ){
			$this->response(404);
		}
		
		$asyncEventRunner = $this->app->getComponent('asyncEventRunner');
		$asyncEventRunner->raiseAsyncEvent('onBeforeRegisterSuccess',array(
				'mobile' => $mobile
		));
	}
	
	//发送重置密码验证码
	public function actionSendResetVerify(){
		$mobile = $this->getQuery('mobile');
		if ( $mobile === null ){
			$this->response(404);
		}
		
		$asyncEventRunner = $this->app->getComponent('asyncEventRunner');
		$asyncEventRunner->raiseAsyncEvent('onResetPassword',array(
				'mobile' => $mobile
		));
	}
	
	//重置验证页面
	public function actionResetPasswordVerify(){
		$cache = $this->app->cache;
		$post = $this->getPost('Verify');
		$form = new ResetPasswordForm();
		
		if ( $post !== null ){
			$form->attributes = $post;
			if ( $form->validate() ){
				$cacheKey = 'RESET_PASSWORD_'.$form->mobile;
				$cache->set($cacheKey,array('id'=>$form->id,'mobile'=>$form->mobile),1800);
				$this->redirect($this->createUrl('account/resetPassword',array('mobile'=>$form->mobile)) );
			}
		}
		
		if ( $form->hasErrors() ){
			$alertErrors = '';
			foreach ( $form->getErrors() as $errors ){
					foreach ( $errors as $error ){
						$alertErrors = $error.'\n';
					}
			}
			$this->cs->registerScript('error','alert("'.$alertErrors.'")',CClientScript::POS_END);
		}
		
		
		$this->cs->registerCssFile($this->cssUrl.'login.css');
		$this->cs->registerScriptFile($this->scriptUrl.'login.js',CClientScript::POS_END);
		
		$this->render('resetPassword',array('form'=>$form));
	}
	
	//重置密码页面
	public function actionResetPassword(){
		$mobile = $this->getQuery('mobile');
		$cache = $this->app->cache;
		$cacheKey = 'RESET_PASSWORD_'.$mobile;
		
		if ( $cache->get($cacheKey) === $mobile ){
			$password = $this->getPost('password',null);
			if ( $password !== null ){
				
			}
		}else {
			throw new CHttpException(403);
		}
	}
}
