<?php
/**
 * file: main.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-16
 * desc: 
 */
return array(
	'alipay' => array(
		//合作身份者id，以2088开头的16位纯数字
		'partner' => '2088002995371000',
		//安全检验码，以数字和字母组成的32位字符
		'key' => 'zo67sbf6teku60tme7fle4xzae1yxzzw',
		//签名方式 不需修改
		'sign_type' => strtoupper('MD5'),
		//字符编码格式 目前支持 gbk 或 utf-8
		'input_charset' => strtolower('utf-8'),
		//ca证书路径地址，用于curl中ssl校验
		'cacert' => Yii::getPathOfAlias('pay.extensions.alipay.cacert').'.pem',
		//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
		'transport' => 'http',
		
		//支付类型 - 必填，不能修改
		'payment_type' => 1,
		'service' => 'trade_create_by_buyer',//'create_direct_pay_by_user',
		//卖家支付宝帐户
		'seller_email' => '295395100@qq.com',
		//服务器异步通知页面路径
		'notify_url' => 'http://127.0.0.1:8080'.Yii::app()->createUrl("pay/alipay/notify"),
		//页面跳转同步通知页面路径
		'return_url' => 'http://127.0.0.1:8080'.Yii::app()->createUrl("pay/alipay/return"),
		//商品展示地址
		'show_url' => 'http://127.0.0.1:8080'.Yii::app()->createUrl("pay/index"),
	),
);