<?php
class ExcelOutputController extends Admin{
	public function filters(){
		$filters = parent::filters();
		return $filters;	
	}

	/*
	**导出会员信息
	*/
	public function actionUserDataOutPut(){
		$criteria = new CDbCriteria;
		$dataArray = array();
		$titleArray = array();

		$userData = FrontUser::model()->findAll($criteria);
		if(!empty($userData)){
			foreach($userData as $value){
				if($value->gender == 0)
					$gender = '女';
				elseif($value->gender == 1)
					$gender = '男';
				else
					$gender ='保密';

				if($value->role == 'wddz')
					$role = '网店店主';
				elseif($value->role == 'qyz')
					$role = '企业主';
				elseif($value->role == 'gxjc')
					$role = '工薪阶层';
				else
					$role = null;

				$dataArray[] = array(
								'0'=>$value->id,
								'1'=>$value->nickname,
								'2'=>$value->realname,
								'3'=>$value->balance/100,
								'4'=>$gender,
								'5'=>$value->mobile,
								'6'=>$value->email,
								'7'=>$value->address,
								'8'=>$value->identity_id,
								'9'=>$value->bank,
								'10'=>$role,
								'11'=>$value->credit_grade

							);

				$titleArray = array(
								'0'=>'用户编号',
								'1'=>'用户昵称',
								'2'=>'真实姓名',
								'3'=>'用户余额',
								'4'=>'性别',
								'5'=>'手机',
								'6'=>'邮箱',
								'7'=>'地址',
								'8'=>'身份证号',
								'9'=>'银行卡号',
								'10'=>'角色',
								'11'=>'信用分数'
							);

			}

		$output = $this->app->getModule('user')->getComponent('infoDisposeManager')->ExcelOutput($titleArray,$dataArray);
		}
	}


	/*
	**导出会员级别配置列表
	*/
	public function actionCreditLevelOutPut(){
		$criteria = new CDbCriteria;
		$dataArray = array();
		$titleArray = array();

		$levelData = CreditGradeSettings::model()->findAll($criteria);
		if(!empty($levelData)){

			foreach($levelData as $value){
				if($value->loanable == '0')
					$loanable = '不可以';
				elseif($value->loanable == '1')
					$loanable = '可以';

				$dataArray[] = array(
								'0'=>$value->label,
								'1'=>$value->start,
								'2'=>$value->on_recharge.'%',
								'3'=>$value->on_withdraw.'%',
								'4'=>$value->on_pay_back.'%',
								'5'=>$value->on_over6.'%',
								'6'=>$value->on_below6.'%',
								'7'=>$value->on_loan.'%',
								'8'=>$loanable,
							);

				$titleArray = array(
								'0'=>'会员级别',
								'1'=>'会有分数',
								'2'=>'充值利率',
								'3'=>'提现利率',
								'4'=>'还款利率',
								'5'=>'借款6个月以上利率',
								'6'=>'借款6个月以下利率',
								'7'=>'标段利息利润利率',
								'8'=>'该级别是否允许借贷',
							);
			}
			$output = $this->app->getModule('user')->getComponent('infoDisposeManager')->ExcelOutput($titleArray,$dataArray);
		}		
	}

	/*
	**导出标段数据
	*/

} 
?>