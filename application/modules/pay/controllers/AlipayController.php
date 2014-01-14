<?php
/**
 * file: AlipayController.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-16
 * desc: Alipay即时到账交易接口接入页
 */
/*class AlipayController extends PayController{
	protected $platform = 'alipay';
	
	public function init(){
		parent::init();
		$this->module->setImport(array(		
			'pay.extensions.alipay.*'	
		));
	}
	
	public function actionOrder(){
		$order = $this->getPayOrder();
		$price = ($order->getAttribute('sum') + $order->getAttribute('fee')) / 100;

		$alipay = $this->module->alipay;
		//构造要请求的参数数组，无需改动
		$parameter = array(
			"service" => $alipay['service'],
			"partner" => trim($alipay['partner']),
			"payment_type"	=> $alipay['payment_type'],
			"notify_url"	=> $alipay['notify_url'],
			"return_url"	=> $alipay['return_url'],
			"show_url"	=> $alipay['show_url'],
			"seller_email"	=> $alipay['seller_email'],
			//商户网站订单系统中唯一订单号，必填
			"out_trade_no"	=> $order->getAttribute('id'),
			//订单名称
			"subject"	=> '闪电贷：'.$price.'元',
			//订单描述
			"body"	=> '闪电贷：'.$price.'元（含手续费：'.($order->getAttribute('fee') / 100).'元）',
			//"total_fee"	=> $total_fee,
			"price" => $price,
			
			'quantity' => 1,
			'logistics_fee' => '0.00',
			'logistics_type' => 'EXPRESS',
			'logistics_payment' => 'SELLER_PAY',
			
			//防钓鱼时间戳
			//若要使用请调用类文件submit中的query_timestamp函数
			"anti_phishing_key"	=> "",
			//客户端的IP地址
			//非局域网的外网IP地址，如：221.0.0.1
			"exter_invoke_ip"	=> "",
			"_input_charset"	=> trim(strtolower($alipay['input_charset']))
		);

		$alipaySubmit = new AlipaySubmit($alipay);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "");
		echo $html_text;
	}
	
	public function actionNotify(){
		$alipayNotify = new AlipayNotify($this->module->alipay);
		$verify_result = $alipayNotify->verifyNotify();
		
		if($verify_result) { //验证成功
			//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//如果有做过处理，不执行商户的业务程序
			if($this->getPost('trade_status') == 'TRADE_SUCCESS'){
				//注意：
				//该种交易状态只在一种情况下出现——开通了高级即时到账，买家付款成功后。
				$this->trade_no = $this->getPost('trade_no');
				$this->subject = $this->getPost('subject');
				$this->buyer = $this->getPost('buyer_email');
				$this->buyer_id = $this->getPost('buyer_id');
				$this->beginPay($this->getPost('out_trade_no'));
			} else if($this->getPost('trade_status') == 'TRADE_FINISHED') {
				//注意：
				//该种交易状态只在两种情况下出现
				//1、开通了普通即时到账，买家付款成功后。
				//2、开通了高级即时到账，从该笔交易成功时间算起，过了签约时的可退款时限（如：三个月以内可退款、一年以内可退款等）后。
				$this->afterPay($this->getPost('out_trade_no'));
			}
			echo "success";
		}else{ //验证失败
			echo "fail";
			//调试用，写文本函数记录程序运行情况是否正常
			//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
	}
	
	public function actionReturn(){
		$alipayNotify = new AlipayNotify($this->module->alipay);
		$verify_result = $alipayNotify->verifyReturn();
		
		if($verify_result) { //验证成功
			if($this->getQuery('trade_status') == 'TRADE_FINISHED' || $this->getQuery('trade_status') == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
				$this->trade_no = $this->getQuery('trade_no');
				$this->subject = $this->getQuery('subject');
				$this->buyer = $this->getQuery('buyer_email');
				$this->buyer_id = $this->getQuery('buyer_id');
				if($this->beginPay($this->getQuery('out_trade_no'))){
					
				}
			}
		}else{ //验证失败
			
		}
	}
}*/