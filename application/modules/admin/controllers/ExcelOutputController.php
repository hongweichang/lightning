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
	public function actionBidDataOutput(){
		$criteria = new CDbCriteria;
		$dataArray = array();
		$titleArray = array();

		$bidData = BidInfo::model()->with('user')->findAll($criteria);
		if(!empty($bidData)){
			foreach($bidData as $value){
				if($value->verify_progress == '21')
					$status = '正在招标';
				elseif($value->verify_progress == '31')
					$status = '满标';
				elseif($value->verify_progress == '30')
					$status = '流标';
				elseif($value->verify_progress == '41')
					$status = '完成';
				elseif($value->verify_progress == '11')
					$status = '提交待审';
				elseif($value->verify_progress == '20')
					$status = '未通过';
				$dataArray[] = array(
							'0'=>$value->id,
							'1'=>$value->title,
							'2'=>$value->description,
							'3'=>$value->sum/100,
							'4'=>$value->month_rate,
							'5'=>date('Y-m-d H:i:s',$value->start),
							'6'=>date('Y-m-d H:i:s',$value->end),
							'7'=>$value->deadline.'个月',
							'8'=>$status,
							'9'=>$value->getRelated('user')->realname,
							'10'=>$value->getRelated('user')->mobile
						);

				$titleArray = array(
							'0'=>'标段编号',
							'1'=>'标段标题',
							'2'=>'标段简介',
							'3'=>'标段金额',
							'4'=>'利率',
							'5'=>'招标开始时间',
							'6'=>'招标结束时间',
							'7'=>'还款期限',
							'8'=>'标段状态',
							'9'=>'用户姓名',
							'10'=>'用户手机'
						);				
			}
			$output = $this->app->getModule('user')->getComponent('infoDisposeManager')->ExcelOutput($titleArray,$dataArray);

		}


	}

	
	/*
	**提现列表导出
	*/
	public function actionWithDraw(){
		$criteria = new CDbCriteria;
		$dataArray = array();
		$titleArray = array();

		$cashData = Withdraw::model()->with('user')->findAll($criteria);

		if(!empty($cashData)){
			foreach($cashData as $value){
				$userData = $value->getRelated('user');
				if($value->finish_time == '0')
					$finish_time = null;
				else
					$finish_time = date('Y-m-d H:i:s',$value->finish_time);

				if($value->status == '0')
					$status = '等待处理';
				elseif($value->status == '1')
					$status = '提现完成';
				elseif($value->status == '2')
					$status = '提现请求未通过';

				$dataArray[] = array(
								'0'=>$userData->realname,
								'1'=>$userData->mobile,
								'2'=>$userData->bank,
								'3'=>$value->sum,
								'4'=>$value->fee,
								'5'=>date('Y-m-d H:i:s',$value->raise_time),
								'6'=>$finish_time,
								'7'=>$status
							);

				$titleArray = array(
								'0'=>'用户姓名',
								'1'=>'用户手机',
								'2'=>'银行卡号',
								'3'=>'提现金额',
								'4'=>'手续费',
								'5'=>'提交时间',
								'6'=>'完成时间',
								'7'=>'提现状态'
							);
			}
			$output = $this->app->getModule('user')->getComponent('infoDisposeManager')->ExcelOutput($titleArray,$dataArray);
		}		
	}



} 
?>