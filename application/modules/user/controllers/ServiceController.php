<?php
/*
**用户模块API服务
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/

class ServiceController extends Controller{
	public function filters(){
		return array();
	}

	public function actionGetCreditGrade($id){
		if(!empty($id) && is_numeric($id)){

			$userData = FrontUser::model()->findByPk($id);
			if(!empty($userData)){
				$userCredit = $userData[0]->credit_grade;
				$this->response(200,'',$credit_grade);
			}else
				$this->response(400,'用户不存在','');
		}
	}
}
?>