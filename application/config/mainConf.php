<?php
/**
 * @name mainConf.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-14 
 * Encoding UTF-8
 */
class mainConf extends ConfigBase{
	public function init($owner){
		parent::init($owner);
		$this->debug = true;
		$this->traceLevel = 3;
	}
	
	public function merge(){
		return array(
				'modules' => array(
						'gii'=>array(
								'class'=>'system.gii.GiiModule',
								'password'=>'lancelot!410',
								'ipFilters'=>array('127.0.0.1','::1'),
						),
						'pay'=>array(
								
						),
				),
				'import' => array(
						
				),
				'components' => array(
						'db' => array(
								'class' => 'system.db.CDbConnection',
								'autoConnect' => false,
								'connectionString' => 'mysql:host=localhost;dbname=lightning',
								'emulatePrepare' => true,
								'username' => 'root',
								'password' => 'toruneko',
								'charset' => 'utf8',
								'tablePrefix' => 'xcms_'
						),
						/*
						'cacheDb' => array(
								'class' => 'CDbCache',
								'connectionID' => 'db',
								'cacheTableName' => 'xcms_yii_cache',
								'autoCreateCacheTable' => false
						),
						'cacheMem' => array(),
						'cacheApc' => array(),
						*/
						'urlManager'=>array(
								'urlFormat'=>'path',
								'urlSuffix' => '',
								'showScriptName' => false,
						),
						'log'=>array(
								'class'=>'CLogRouter',
								'routes'=>array(
										array(
												'class'=>'CWebLogRoute',
												//'levels'=>'error, warning',
										),
								),
						),
				)
		);
	}
}