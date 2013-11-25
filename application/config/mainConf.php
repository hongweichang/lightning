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
								'password'=>'admin',
								'ipFilters'=>array('127.0.0.1','::1'),
						),

						'pay' => array(
								'class' => 'application.modules.pay.PayModule'
						),
						
						'user' => array(
								'class' => 'application.modules.user.UserModule'
						),
						'credit' =>array(
								'class' => 'application.modules.credit.CreditModule'
						),
				),
				'import' => array(
						
				),
				'components' => array(
						//remote database on aliyun.remote ip
						'db' => array(
								'class' => 'system.db.CDbConnection',
								'autoConnect' => false,
								'connectionString' => 'mysql:host=115.29.240.98;dbname=lightning',
								'emulatePrepare' => true,
								'username' => 'lancelot',
								'password' => 'lancelot@lightningdbmysqladmin',
								'charset' => 'utf8',
								'tablePrefix' => 'xcms_'
						),
						'user' => array(
								'class' => 'cms.modules.accessControl.components.AuthUser',
								'stateKeyPrefix' => 'FU',
								'allowAutoLogin' => true,
								'autoRenewCookie' => true,
								'guestName' => '游客',
								'authTimeout' => 3600
						),
						//internal database.ip 10.161.180.53
						/*
						'db' =>array(
								'class' => 'system.db.CDbConnection',
								'autoConnect' => false,
								'connectionString' => 'mysql:host=10.161.180.53;dbname=lightning',
								'emulatePrepare' => true,
								'username' => 'lancelot',
								'password' => 'lancelot@lightningdbmysqladmin',
								'charset' => 'utf8',
								'tablePrefix' => 'xcms_'
						),*/
						//local database
						/*
						 'db' =>array(
						 		'class' => 'system.db.CDbConnection',
						 		'autoConnect' => false,
						 		'connectionString' => 'mysql:host=localhost;dbname=lightning',
						 		'emulatePrepare' => true,
						 		'username' => 'lancelot',
						 		'password' => 'lancelot@lightningdbmysqladmin',
						 		'charset' => 'utf8',
						 		'tablePrefix' => 'xcms_'
						 ),*/
						'cache' => array(
								'class' => 'CMemCache',
								'useMemcached' => true,
								'servers' => array(
										array(
												//本地memcached缓存
												'host' => 'localhost',
												//阿里云外网IP
												//'host' => '115.29.186.221',
												//阿里云内网IP，本地测试可以使用本地memcached服务器
												//'host' => '10.161.138.206',
												'port' => 11211
										),
								),
						),
						/*
						'cacheDb' => array(
								'class' => 'CDbCache',
								'connectionID' => 'db',
								'cacheTableName' => 'xcms_yii_cache',
								'autoCreateCacheTable' => false
						),
						'cacheApc' => array(),
						*/
						'clientScript' => array(
								'scriptMap' => array(
										'jquery.js' => false,
										'jquery.min.js' => false,
										'jquery.ba-bbq.js' => false
								)
						),
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
				),
				'params' => array(
						'copyright' => '<p>重庆闪电贷金融信息服务有限公司 版权所有 2007-2013<p><p>Copyright Reserved 2007-2013&copy;闪电贷（www.sddai.com） | 渝ICP备05063398号</p>'
				),
		);
	}
}