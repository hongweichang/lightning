<?php
/**
 * file: IpsController.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-20
 * desc: 环迅支付p2p交易接口接入页
 */
class IpsController extends PayController{
	protected $platform = 'ips';
	
	public function filters(){
		return array();
	}
	
	public function actionIndex(){
		
	}
}