<?php

class PayModule extends CmsModule
{
	public $alipay;
	public $ips;
	
	public function init()
	{
		parent::init();
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		$config = require Yii::getPathOfAlias('pay.config.main').'.php';
		$this->configure($config);
		// import the module-level models and components
		$this->setImport(array(
			'pay.models.*',
			'pay.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

	/**
	 * 提交一个提现申请，等待后台处理
	 * @param float $charge
	 * @param float $fee
	 * @return boolean
	 */
	public function beginWithdraw($charge,$fee){
		$db = new Withdraw();
		$db->attributes = array(
			'user_id' => Yii::app()->user->getState('id'),
			'sum' => $charge * 100,
			'fee' => round($fee * 100),
			'raise_time' => time(),
			'status' => 0, // 正在处理 - 等待后台处理
		);
	
		return $db->save();
	}
	
	/**
	 * 后台处理提现申请
	 * @param string $trade_no
	 * @return boolean
	 */
	public function afterWithdraw($trade_no){
		$record = Withdraw::model()->findByPk($trade_no);
	
		$record->attributes = array(
			'finish_time' => time(),
			'status' => 1,
		);
	
		return $record->save();
	}
	
	/**
	 * 站内点对点资金流动
	 * @param int $fromuid 资金来源
	 * @param int $touid 资金去向
	 * @param double $charge 资金
	 * @param double $fee 手续费
	 * @return boolean
	 */
	public static function p2p($fromuid,$touid,$charge,$fee){
		$db = new FundFlowInternal();
		$db->attributes = array(
			'to_user' => $touid,
			'from_user' => $fromuid,
			'sum' => $charge * 100,
			'fee' => round($fee * 100), // 四舍五入??
			'time' => time(),
			'status' => 1 // 暂时不分过程
		);
		
		return $db->save();
	}
}
