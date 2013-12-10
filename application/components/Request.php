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
}