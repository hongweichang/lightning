<?php
/**
 * file: IpsNotify.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-24
 * desc: Ips通知处理类
 */
class IpsNotify{
	private $ips_config;
	
	public function IpsNotify($config){
		$this->ips_config = $config;
	}
	
	public function verify(){
		if(empty($_GET)){
			return false;
		}else{
			return $this->getSignVeryfy($_GET, $_GET['signature']);
		}
	}
	
	/**
	 * 获取返回时的签名验证结果
	 * @param array $para_temp 通知返回来的参数数组
	 * @param string $sign 返回的签名结果
	 * @return boolean 签名验证结果
	 */
	function getSignVeryfy($para_temp, $sign) {
		//除去待签名参数数组中无用的签名参数
		$para_filter = IpsCore::paraFilter($para_temp);
	
		//对待签名参数数组排序
		$para_sort = IpsCore::argSort($para_filter);
	
		//把数组所有元素，按照“参数参数值”的模式拼接成字符串
		$prestr = IpsCore::createSignString($para_sort);
	
		$isSgin = false;
		switch (strtoupper(trim($this->ips_config['RetEncodeType']))) {
			case "17" :
				$isSgin = IpsMd5::md5Verify($prestr, $sign, $this->ips_config['Mer_key']);
				break;
			default :
				$isSgin = false;
		}
	
		return $isSgin;
	}
}