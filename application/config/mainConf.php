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
				'hostName' => 'http://localhost',
				'preloadModels' => array(),
				'modules' => array(
						'pay',
						'user',
						'credit',
						'tender',
						'appservice',
						'content',
						'gii'=>array(
								'class'=>'system.gii.GiiModule',
								'password'=>'admin',
								'ipFilters'=>array('127.0.0.1','::1'),
						),
						'adminnogateway' => array(
							'class' => 'application.modules.admin.AdminModule',
							'name' => 'adminnogateway'
						),
						'notify' => array(
								'class' => 'application.modules.notify.NotifyModule',
								'email' => array(
										'pathViews' => 'application.views.email',
										'pathLayouts' => 'application.views.email.layouts',
										'ccEmail'=>'',//抄送
										'Mailer' => 'smtp',
										'Host'=>'smtp.qq.com',
										'Port'=>'25',
										'SMTPAuth'=>true,
										'Username'=>'574891711',
										'Password'=>'lancelot@410',
										'From'=>'574891711@qq.com',
										'FromName'=>'闪电贷',
										'CharSet'=>'UTF-8',
								),
								'manager' => array(
										'smsAPI' => 'http://sdk105.entinfo.cn/z_mdsmssend.aspx?sn=SDK-CSL-010-00245&pwd=69C90CB4B5E98574108BB62974EB0DF4',
										'cacheID' => 'cache'
								)
						),
				),
				'import' => array(
						'application.extensions.PHPExcel.PHPExcel.*',
						'application.modules.user.models.*'
				),
				'preload' => array(
						//'asyncEventRunner'
				),
				'components' => array(
						'user' => array(
								'class' => 'application.modules.user.components.LightningUser',
								'stateKeyPrefix' => 'FU',
								'allowAutoLogin' => true,
								'autoRenewCookie' => true,
								'guestName' => '游客',
								'authTimeout' => 3600,
						),
						//remote database on aliyun.remote ip
						'db' => array(
						 		'class' => 'system.db.CDbConnection',
								'autoConnect' => false,
								'connectionString' => 'mysql:host=115.29.173.40;dbname=lightning',
								'emulatePrepare' => true,
								'username' => 'lancelot',
								'password' => 'lancelot@lightningdbmysqladmin',
								'charset' => 'utf8',
								'tablePrefix' => 'xcms_',
								'schemaCacheID' => 'cache',//表结构缓存
								'schemaCachingDuration' => 3600,//缓存1小时
						),
						'request' => array(
								'class' => 'application.components.Request',
								'enableCookieValidation' => true
						),
						'cache' => array(
								'class' => 'CMemCache',
								'useMemcached' => true,
								'keyPrefix' => 'lightning',
								'servers' => array(
										array(
												//'host' => 'localhost',
												//本地memcached缓存
												//阿里云外网IP
												'host' => '115.29.186.221',
												//阿里云内网IP，本地测试可以使用本地memcached服务器
												//'host' => '10.161.138.206',
												'port' => 11211
										),
								),
						),

						'session' => array(
								'class'=> 'CHttpSession',
								//'cacheID' => 'cache',
								'autoStart' => true,
								'timeout' => 3600*24
						),
						'clientScript' => array(
								'scriptMap' => array(
										'jquery.js' => false,
										'jquery.min.js' => false,
										'jquery.ba-bbq.js' => false
								)
						),
						'urlManager'=>array(
								'urlFormat'=>'path',
								'cacheID' => false,
								'urlSuffix' => '',
								'showScriptName' => false,
								'rules' => require dirname(__FILE__).'/RestApiRules.php',
						),
						'log'=>array(
								'class'=>'CLogRouter',
								'routes'=>array(
										array(
												'class'=>'CWebLogRoute',
												//'levels'=>'error, warning',
												'except' => 'access.*'
										),
										array(
												'class' => 'CProfileLogRoute'
										)
								),
						),
						/*'zmqClient' => array(
								'class' => 'cms.components.asyncEvent.ZMQClient',
								'zmqServer' => 'tcp://localhost:5556',
								'sendTimeout' => 3000,
								'reciveTimeout' => 3000,
						),
						'zmqPurchaseClient' => array(
								'class' => 'cms.components.asyncEvent.ZMQClient',
								'zmqServer' => 'tcp://localhost:5558',
								'sendTimeout' => 3000,
								'reciveTimeout' => 3000,
						),
						'asyncEventRunner' => require dirname(__FILE__).'/asyncEventRunner.config.php',*/
						'image'=>array(
								'class'=>'ext.image.CImageComponent',
								'driver'=>'GD',
								'params'=>array('directory'=>'/opt/local/bin'),
						),
				),
				'params' => require dirname(__FILE__).'/params.php',
		);
	}
}
