<?php
/**
 * file: main.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-16
 * desc: 
 */
return array(
	/*'alipay' => array(
		//合作身份者id，以2088开头的16位纯数字
		'partner' => '',
		//安全检验码，以数字和字母组成的32位字符
		'key' => '',
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
		'notify_url' => Yii::app()->hostName.Yii::app()->createUrl("pay/alipay/notify"),
		//页面跳转同步通知页面路径
		'return_url' => Yii::app()->hostName.Yii::app()->createUrl("pay/alipay/return"),
		//商品展示地址
		'show_url' => Yii::app()->hostName.Yii::app()->createUrl("pay/platform/bill"),
	),*/
	
	'ips' => array(
		//IPS商户编号
		'Mer_code' => '025841',
		//'Mer_code' => '000015',
		//'Mer_key' => 'GDgLwwdK270Qj1w4xho8lyTpRQZV9Jm5x4NwWOTThUa4fMhEBK9jOXFrKRT6xhlJuU2FEa89ov0ryyjfJuuPkcGzO5CeVx5ZIrkkt1aBlZV36ySvHOMcNv8rncRiy3DQ',
		//IPS商户证书
		'Mer_key' => 'sbr0wmWfKAGXxcstBpXJk2sY3UvuAALDreUX9QdHfeZlMDxDTjdOuMXqkJwRrbU9p3fH8KjlBEd4S6BqWhRSXwJV7eorUBR39QwHYf58zsCehSNc66v9A2cskAATVsG0',
		//币种
		'Currency_Type' => 'RMB',
		//支付卡种
		'Gateway_Type' => '01', // 人民币储蓄卡
		//支付结果成功返回的商户URL
		'Merchanturl' => Yii::app()->hostName.Yii::app()->createUrl("pay/ips/return"),
		//支付结果失败返回的商户URL
		//'Failurl' => Yii::app()->hostName.Yii::app()->createUrl("pay/ips/return"),
		//商户数据包,该数据包会被原封不动的返回
		//'Attach' => '',
		//订单支付接口加密方式
		'OrderEncodeType' => '5', //MD5
		//交易返回加密方式
		'RetEncodeType' => '17', // MD5
		//是否提供Server返回方式
		'Rettype' => 1,
		//Server to Server返回页面
		'ServerUrl' => Yii::app()->hostName.Yii::app()->createUrl("pay/ips/notify"),
	),
);