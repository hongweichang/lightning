<?php
/**
 * @name Request.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-11 
 * Encoding UTF-8
 */
class Request extends CHttpRequest{
	public function getUserHostAddress(){
		if ( isset($_SERVER['x-forwarded-for']) ){
			return $_SERVER['forwarded'];
		}else {
			return parent::getUserHostAddress();
		}
	}
	
	public function getIpLocation($ip){
		if ( extension_loaded('qqwry') ){
			$qqwry = new qqwry(Yii::getPathOfAlias('application.data.qqwry').'.dat');
			list($location,$yys) = $qqwry->q($ip);
			$location = iconv('GB2312','UTF-8',$location);
			return $location;
		}else {
			return '未知地区';
		}
	}
}