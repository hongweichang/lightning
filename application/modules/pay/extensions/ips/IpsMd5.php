<?php
/**
 * file: IpsMd5.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-24
 * desc: MD5加密
 */
class IpsMd5{
	/**
	 * 签名字符串
	 * @param string $prestr 需要签名的字符串
	 * @param string $key 私钥
	 * @return string 签名结果
	 */
	public static function md5Sign($prestr, $key) {
		$prestr = $prestr . $key;
		return md5($prestr);
	}
	
	/**
	 * 验证签名
	 * @param string $prestr 需要签名的字符串
	 * @param string $sign 签名结果
	 * @param string $key 私钥
	 * @return boolean 签名结果
	 */
	public static function md5Verify($prestr, $sign, $key) {
		$prestr = $prestr . $key;
		$mysgin = md5($prestr);
	
		if($mysgin == $sign) {
			return true;
		} else {
			return false;
		}
	}
}