<?php
/**
 * file: FundController.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-14
 * desc: 
 */
class FundController extends Admin{
	public function init(){
		parent::init();
		$this->app->getModule('pay');
		$this->app->getModule('tender');
		$this->app->getModule('user');
	}
	
	public function actionInvestment(){
		$criteria = new CDbCriteria();
		//$criteria->addCondition('status=0');
		
		//$selector = Selector::load('RechargeSelector',$this->getQuery('RechargeSelector'),$criteria);
		
		$dataProvider = new CActiveDataProvider('FundFlowInternal',array(
				'criteria' => $criteria,
				'countCriteria' => array(
						'condition' => $criteria->condition,
						'params' => $criteria->params
				),
				'pagination' => array(
						'pageSize' => 20
				),
		));
		$this->tabTitle = '站内资金流动记录';
		//$this->addNotifications('搜索','information',true);
		$this->render('waitting',array(
				'dataProvider' => $dataProvider,
				//'selector' => $selector
		));
	}
	
	public function actionSite(){

		$this->render('site',array(
			'sum' => FrontUser::model()->sum('balance') / 100, //用户总额
			'recharge' => Recharge::model()->sum('sum','status=1 or status=2') / 100, //充值
			'withdraw' => Withdraw::model()->sum('sum','status=1') / 100, //提现
			'recharge_fee' => Recharge::model()->sum('fee') / 100, // 支付平台扣费
			'income' => FundFlowInternal::model()->sum('fee') / 100, //平台收入
			'view' => BidInfo::model()->sum('sum','verify_progress=11') / 100,//暂未审核通过
			'biding' => BidInfo::model()->sum('sum','verify_progress=21') / 100,//正在招标
			'repaying' => BidInfo::model()->sum('sum','verify_progress=31') / 100,//已还款
			'done' => BidInfo::model()->sum('sum','verify_progress=41') / 100, //已完成标段
			'lose' => BidInfo::model()->sum('sum','verify_progress=30') / 100, // 流标资金
			'daly' => BidInfo::model()->sum('sum','verify_progress=40') / 100, // 逾期资金
		));
	}
}