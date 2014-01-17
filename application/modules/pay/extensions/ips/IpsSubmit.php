<?php
/**
 * file: IpsSubmit.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-24
 * desc: Ips各接口请求提交类
 */
class IpsSubmit{

	/**
	 * 正式 https://pay.ips.com.cn/ipayment.aspx
	 * 测试 https://pay.ips.net.cn/ipayment.aspx
	 */
	private $form_url = 'https://pay.ips.com.cn/ipayment.aspx';
	private $ips_config;
	
	public function __construct($ips_config){
		$this->ips_config = $ips_config;
	}
	
	/**
	 * 生成签名结果
	 * @param array $para_sort 已排序要签名的数组
	 * @return string 签名结果字符串
	 */
	public function buildRequestMysign($para_sort) {
		//把数组所有元素，按照“参数参数值”的模式接成字符串
		$prestr = IpsCore::createSignstring($para_sort);
	
		$mysign = "";

		switch (strtoupper(trim($this->ips_config['OrderEncodeType']))) {
			case "5" :
				$mysign = IpsMd5::md5Sign($prestr, $this->ips_config['Mer_key']);
				break;
			default :
				$mysign = "";
		}
	
		return $mysign;
	}
	
	/**
	 * 生成要请求给IPS的参数数组
	 * @param array $para_temp 请求前的参数数组
	 * @return array 要请求的参数数组
	 */
	function buildRequestPara($para_temp) {
		//除去待签名参数数组中无用签名参数
		$para_filter = IpsCore::paraFilter($para_temp);
	
		//对待签名参数数组排序
		$para_sort = IpsCore::argSort($para_filter);
	
		//生成签名结果
		$mysign = $this->buildRequestMysign($para_sort);
	
		//签名结果与签名方式加入请求提交参数组中
		$para_temp['SignMD5'] = $mysign;
	
		return $para_temp;
	}
	
	/**
	 * 建立请求，以表单HTML形式构造（默认）
	 * @param array $para_temp 请求参数数组
	 * @param string $method 提交方式。两个值可选：post、get
	 * @param string $button_name 确认按钮显示文字
	 * @return string 提交表单HTML文本
	 */
	function buildRequestForm($para_temp, $method, $button_name) {
		//待请求参数数组
		$para = $this->buildRequestPara($para_temp);
	
		$sHtml = "<form id='ips' name='ips' action='".$this->form_url."' method='".$method."'>";
		foreach($para as $key => $val){
			$sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
		}
	
		//submit按钮控件请不要含有name属性
		//$sHtml = $sHtml."<input type='submit' value='".$button_name."'></form>";
	
		$sHtml = $sHtml."<script>document.forms['ips'].submit();</script>";
	
		return $sHtml;
	}
}