<?php
/*
**支付模块API服务
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/

class AppPayController extends Controller{
	public function filters(){
		return array();
	}

	/*
	**用户支付投标金额
	*/
	public function actionPayPurchasedBid(){
		$post = $this->getPost();

		if(!empty($post)){
			$paypassword = $post['payPassword'];
			$metaId = $post['id'];

			$uid = $this->user->id;
			$userData = FrontUser::model()->findByPk($uid);
			$userPayPassword = $userData->pay_password;

			$security = Yii::app()->getSecurityManager();
			$passwordVerify = $security->verifyPassword($paypassword,$userPayPassword);
			if($passwordVerify !== true){
				$this->response('400','支付密码验证失败','');
				exit();
			}else{
				$pay = Yii::app()->getModule('tender')->bidManager->payPurchasedBid($metaId);
				if($pay === true){
					$this->response('200','支付成功','');
				}else{
					$this->response('401','支付失败，参数错误','');
				}
			}


		}else
			$this->response('402','支付失败,参数不能为空','');
	}

}
?>