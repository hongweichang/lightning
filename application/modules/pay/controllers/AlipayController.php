<?php
/**
 * file: AlipayController.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-16
 * desc: Alipay即时到账交易接口接入页
 */
class AlipayController extends CmsController{
	
	public function actionIndex(){
		//商户订单号
		//商户网站订单系统中唯一订单号，必填
		$out_trade_no = $_POST['WIDout_trade_no'];
		//订单名称*
		$subject = $_POST['WIDsubject'];
		//付款金额*
		$total_fee = $_POST['WIDtotal_fee'];
		//订单描述
		$body = $_POST['WIDbody'];
		//商品展示地址
		$show_url = $_POST['WIDshow_url'];
		
		//防钓鱼时间戳
		//若要使用请调用类文件submit中的query_timestamp函数
		$anti_phishing_key = "";
		//客户端的IP地址
		//非局域网的外网IP地址，如：221.0.0.1
		$exter_invoke_ip = "";
		
		//构造要请求的参数数组，无需改动
		$parameter = array(
			"service" => $this->module->alipay['service'],
			"partner" => trim($this->module->alipay['partner']),
			"payment_type"	=> $this->module->alipay['payment_type'],
			"notify_url"	=> $this->module->alipay['notify_url'],
			"return_url"	=> $this->module->alipay['return_url'],
			"seller_email"	=> $this->module->alipay['seller_email'],
			"out_trade_no"	=> $out_trade_no,
			"subject"	=> $subject,
			"total_fee"	=> $total_fee,
			"body"	=> $body,
			"show_url"	=> $show_url,
			"anti_phishing_key"	=> $anti_phishing_key,
			"exter_invoke_ip"	=> $exter_invoke_ip,
			"_input_charset"	=> trim(strtolower($this->module->alipay['input_charset']))
		);
		
		$alipaySubmit = new AlipaySubmit($this->module->alipay);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		echo $html_text;
	}
	
	public function actionNotify(){
		$alipayNotify = new AlipayNotify($this->module->alipay);
		$verify_result = $alipayNotify->verifyNotify();
		
		if($verify_result) { //验证成功
			//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//如果有做过处理，不执行商户的业务程序
			if(Yii::app()->request->getPost('trade_status') == 'TRADE_FINISHED') {
				//注意：
				//该种交易状态只在两种情况下出现
				//1、开通了普通即时到账，买家付款成功后。
				//2、开通了高级即时到账，从该笔交易成功时间算起，过了签约时的可退款时限（如：三个月以内可退款、一年以内可退款等）后。
			}else if(Yii::app()->request->getPost('trade_status') == 'TRADE_SUCCESS'){
				//注意：
				//该种交易状态只在一种情况下出现——开通了高级即时到账，买家付款成功后。
			}
			//调试用，写文本函数记录程序运行情况是否正常
			//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
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
			if(Yii::app()->request->getQuery('trade_status') == 'TRADE_FINISHED' || Yii::app()->request->getQuery('trade_status') == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
			} else {
				//echo "trade_status=".$_GET['trade_status'];
			}
		}else{ //验证失败
			//验证失败
			//如要调试，请看alipay_notify.php页面的verifyReturn函数
		}
	}
}