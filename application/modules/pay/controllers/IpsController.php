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
	
	public function init(){
		parent::init();
		$this->module->setImport(array(	
			'pay.extensions.ips.*'
		));
	}
	
	public function actionIndex(){
		//付款金额
		$charge = 1;//$_POST['charge'];
		//手续费
		$fee = $charge * 0.05;
		
		$ips = $this->module->ips;
		
		$ips['mercode'] = $this->raiseOrder($charge, $fee);
		$ips['amount'] = $charge;
		$ips['date'] = date('Ymd');
		
		$submit = new IpsSubmit($ips);
		$html = $submit->buildRequestForm($ips, 'post', '');
		echo $html;
	}
	
	public function actionReturn(){
		$ipsNotify = new IpsNotify($this->module->ips);
		$result = $ipsNotify->verify();
		
		if($result){
			if($this->getQuery('succ') == 'Y'){
				/**----------------------------------------------------
				 *比较返回的订单号和金额与您数据库中的金额是否相符
				*compare the billno and amount from ips with the data recorded in your datebase
				*----------------------------------------------------
				
				if(不等)
					echo "从IPS返回的数据和本地记录的不符合，失败！"
				exit
				else
					'----------------------------------------------------
				'交易成功，处理您的数据库
				'The transaction is successful. update your database.
				'----------------------------------------------------
				end if
				**/
				$this->trade_no = $this->getQuery('ipsbillno');
				$this->subject = $this->getQuery('subject');
				$this->buyer = $this->getQuery('msg');
				$this->buyer_id = $this->getQuery('bankbillno');
				$this->beginPay($this->getQuery('mercode'));
				$this->afterPay($this->getQuery('mercode'));
			}else{
				//交易失败
			}
		}else{
			//签名不正确
		}
	}
	
	public function actionNotify(){
		$ipsNotify = new IpsNotify($this->module->ips);
		$result = $ipsNotify->verify();
		
		if($result){
			if($this->getQuery('succ') == 'Y'){
				/**----------------------------------------------------
				 *比较返回的订单号和金额与您数据库中的金额是否相符
				*compare the billno and amount from ips with the data recorded in your datebase
				*----------------------------------------------------
		
				if(不等)
					echo "从IPS返回的数据和本地记录的不符合，失败！"
				exit
				else
					'----------------------------------------------------
				'交易成功，处理您的数据库
				'The transaction is successful. update your database.
				'----------------------------------------------------
				end if
				**/
				$this->trade_no = $this->getQuery('ipsbillno');
				$this->subject = $this->getQuery('subject');
				$this->buyer = $this->getQuery('msg');
				$this->buyer_id = $this->getQuery('bankbillno');
				$this->beginPay($this->getQuery('mercode'));
				$this->afterPay($this->getQuery('mercode'));
			}else{
				//交易失败
			}
		}else{
			//签名不正确
		}
	}
}