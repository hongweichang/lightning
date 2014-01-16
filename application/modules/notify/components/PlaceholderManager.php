<?php
/**
 * @name PlaceholderManager.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-12 
 * Encoding UTF-8
 */
class PlaceholderManager{
	public static $placeholders = array(
			'{userName}' => array(
					'label' => '用户名',
			),
			'{code}' => array(
					'label' => '验证码',
			),
			'{codeLifeTime}' => array(
					'label' => '验证码有效时间(分钟)'
			),
			'{activatingLink}' => array(
					'label' => '帐号激活链接',
			),
			'{credit}' => array(
					'label' => '上传的信用资料',
			),
			'{creditFailedReason}' => array(
					'label' => '信用资料审核失败原因',
			),
			'{bid}' => array(
					'label' => '标段名称'
			),
			'{bidFailedReason}' => array(
					'label' => '标段审核失败原因'
			),
			'{withdrawalDate}' => array(
					'label' => '申请提现时间'
			),
			'{money}' => array(
					'label' => '还款金额'
			),
			'{dayLeft}' => array(
					'label' => '还款剩余期限(到达还款日期前三天和后两天，共五天)'
			)
	);
	
	public static function getPlaceholderLables($names=array()){
		$data = array();
		
		if ( $names === array() ){
			foreach ( self::$placeholders as $name => $value ){
				$data[$name] = $value['label'];
			}
		}else {
			foreach ( $names as $name ){
					if ( isset(self::$placeholders[$name]) ){
						$data[$name] = self::$placeholders[$name]['label'];
					}
			}
		}
		
		return $data;
	}
	
	public static function replacePlaceholders($subject,$values){
		foreach ( $values as $placeholder => $value ){
			$placeholder = preg_quote($placeholder);
			$pattern = '/(.*)'.$placeholder.'(.*)/U';
			$subject = preg_replace($pattern, '${1}'.$value.'${2}', $subject);
		}
		
		return $subject;
	}
}