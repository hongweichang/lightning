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
						'gii'=>array(
								'class'=>'system.gii.GiiModule',
								'password'=>'admin',
								'ipFilters'=>array('127.0.0.1','::1'),
						),

						'pay' => array(
								'class' => 'application.modules.pay.PayModule'
						),
						
						'adminnogateway' => array(
							'class' => 'application.modules.admin.AdminModule',
							'name' => 'adminnogateway'
						),
						
						'user' => array(
								'class' => 'application.modules.user.UserModule'
						),
						'credit' =>array(
								'class' => 'application.modules.credit.CreditModule'
						),
						'tender' =>array(
								'class' => 'application.modules.tender.TenderModule'
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
						),

						'appservice' => array(
								'class' => 'application.modules.appservice.AppserviceModule',
						),
				),
				'import' => array(
						'application.extensions.PHPExcel.PHPExcel.*',
				),
				'preload' => array(
						'asyncEventRunner'
				),
				'components' => array(
						'user' => array(
								'class' => 'application.modules.user.components.LightningUser',
								'stateKeyPrefix' => 'FU',
								'allowAutoLogin' => true,
								'autoRenewCookie' => true,
								'guestName' => '游客',
								'authTimeout' => 3600,
								'avatarPath' => '/upload/avatar/'
						),
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
						'request' => array(
								'class' => 'application.components.Request'
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
								'class'=> 'CCacheHttpSession',
								'cacheID' => 'cache',
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
								'cacheID' => 'cache',
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
								),
						),
						'zmqClient' => array(
								'class' => 'cms.components.asyncEvent.ZMQClient',
								'zmqServer' => 'tcp://localhost:5556',
								'sendTimeout' => 3000,
								'reciveTimeout' => 3000,
						),
						'asyncEventRunner' => array(
								'class' => 'cms.components.asyncEvent.AsyncEventRunner',
								'zmqClientId' => 'zmqClient',
								'logRouterID' => 'log',
								'asyncLogRoutes' => array(
										'accessLog' => array(
												'class' => 'cms.components.asyncEvent.logging.AccessLogRoute',
												'categories' => 'access.*'
										),
								),
								'events' => array(
// 										'onRegisterSuccess' => array(
// 												'command' => array('sendSMS','success')
// 										),
								),
						),
						'image'=>array(
								'class'=>'ext.image.CImageComponent',
								'driver'=>'GD',
								'params'=>array('directory'=>'/opt/local/bin'),
						),
				),
				'params' => array(
						'copyright' => '<p>重庆闪电贷金融信息服务有限公司 版权所有 2007-2013<p><p>Copyright Reserved 2007-2013&copy;闪电贷（www.sddai.com） | 渝ICP备05063398号</p>',
						'asyncEvent' => array(),
						'roleMap' =>array(
								'gxjc' => '工薪阶层',
								'qyz' => '企业主',
								'wddz' => '网店店主',
						),
						'commonUrls' =>array(
								'index' => '/site',
								'useHelp' => '#',
						),
						'bidsPerPage' => 10,//默认的每次请求的标段条数
						
						//标段选择条件参数
						'selectorMap' => array(
								'monthRate' => array(//月利率条件
										'all' => 'all',
										'5%-10%' => ' month_rate BETWEEN 500 AND 1000 ',
										'11%-15%' => ' month_rate BETWEEN 1100 AND 1500 ',
										'16%-20%' => ' month_rate BETWEEN 1600 AND 2000 ',
								),
								'deadline' => array(//借款期限条件
										'all' => 'all',
										'6-12' => ' deadline BETWEEN 6 AND 12 ',
										'12-24' => ' deadline BETWEEN 12 AND 24 ',
										'24-36' => ' deadline BETWEEN 24 AND 36 ',
								),
								'authenGrade' => array(//认证等级条件
										'all' => 'all',
										'AA' => " authenGrade = 'AA' ",
										'AAA' => " authenGrade = 'AAA' ",
										'HR' => " authenGrade = 'HR' ",
								),
						),
						//月利率的查询条件
						'monthRate' => array('5%-10%','11%-15%','16%-20%',),
						//借款期限的查询条件
						'deadline' => array('6-12','12-24','24-36',),
						//认证等级的查询条件
						'authenGrade' => array('AA','AAA','HR',),
				),
		);
	}
}