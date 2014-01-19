<?php
/**
 * @name HelperController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2014-1-20 
 * Encoding UTF-8
 */
class HelperController extends Controller{
	public function init(){
		parent::init();
		$this->cs->registerScriptFile($this->scriptUrl.'jquery.validate.min.js',CClientScript::POS_END);
		$this->cs->registerScriptFile($this->scriptUrl.'calculator.js',CClientScript::POS_END);
		$this->cs->registerCssFile($this->cssUrl.'calc.css');
	}
	/**
	 * 借款计算器（借入）
	 */
	public function actionBorrowCalculate(){
		$credit = $this->app->getModule('credit')->getComponent('userCreditManager');
		$userCreditSettings = $credit->UserRateGet($this->user->id);
		$creditSettings = $credit->UserLevelList();
		
		$data = array(
				'userCreditSettings' => $userCreditSettings,
				'creditSettings' => $creditSettings
		);
		$this->render('borrowCalculate',$data);
	}
	
	/**
	 * 理财计算器（借出）
	 */
	public function actionLendCalculate(){
		$credit = $this->app->getModule('credit')->getComponent('userCreditManager');
		$userCreditSettings = $credit->UserRateGet($this->user->id);
		$creditSettings = $credit->UserLevelList();
		
		$data = array(
				'userCreditSettings' => $userCreditSettings,
				'creditSettings' => $creditSettings
		);
		$this->render('lendCalculate',$data);
	}
}