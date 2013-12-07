<?php
/**
 * file: FundController.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-28
 * desc: 
 */
class FundController extends Controller{
	public function actionIndex(){
		$this->render('/public/entry',array(
			'tab' => array(
				array('网站资金统计',$this->createUrl('')),
				array('投资统计排名',$this->createUrl('')),
				array('会员资金记录',$this->createUrl('')),
				array('费用设置',$this->createUrl('')),
			)
		));
	}
}