<?php
/**
 * file: IpsCore.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-24
 * desc: 该类是请求、通知返回两个文件所调用的公用函数核心处理文件
 */
class IpsCore{
	/**
	 * 把数组所有元素，按照“参数参数值”的模式接成字符串
	 * @param array $para 需要拼接的数组
	 * @return string 拼接完成以后的字符串
	 */
	public static function createSignString($para){
		$arg  = '';
		foreach($para as $key => $val){
			$arg .= strtolower($key).$val;
		}
		
		return $arg;
	}
	
	/**
	 * 除去数组中无用的签名参数
	 * @param array $para 签名参数组
	 * @return array 去掉无用签名参数后的新签名参数组
	 */
	public static function paraFilter($para) {
		$allow = array('mercode','currency_type','amount','date','orderencodetype','succ','ipsbillno','retencodetype');
		$para_filter = array();
		foreach($para as $key => $val){
			if(in_array(strtolower($key), $allow)){
				$para_filter[strtolower($key)] = $val;
			}
		}
		return $para_filter;
	}
	
	/**
	 * 对数组排序
	 * @param array $para 排序前的数组
	 * @return array 排序后的数组
	 */
	public static function argSort($para) {
		$new_para = array(
			'billno' => $para['mercode'],
			'currencytype' => $para['currency_type'],
			'amount' => $para['amount'],
			'date' => $para['date']
		);
		
		if(isset($para['orderencodetype'])){
			$new_para['orderencodetype'] = $para['orderencodetype'];
		}else{
			$new_para['succ'] = $para['succ'];
			$new_para['ipsbillno'] = $para['ipsbillno'];
			$new_para['retencodetype'] = $para['retencodetype'];
		}
		
		return $new_para;
	}
}