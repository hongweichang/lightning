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
				),
				'import' => array(
						'application.extensions.PHPExcel.PHPExcel.*'
						
				),
				'components' => array(
						//remote database on aliyun.remote ip
						/*'db' => array(
								'class' => 'system.db.CDbConnection',
								'autoConnect' => false,
								'connectionString' => 'mysql:host=115.29.186.221;dbname=lightning',
								'emulatePrepare' => true,
								'username' => 'lancelot',
								'password' => 'lancelot@lightningdbmysqladmin',
								'charset' => 'utf8',
								'tablePrefix' => 'xcms_'
						),*/
						'user' => array(
								'class' => 'application.modules.user.components.LightningUser',
								'stateKeyPrefix' => 'FU',
								'allowAutoLogin' => true,
								'autoRenewCookie' => true,
								'guestName' => '游客',
								'authTimeout' => 3600,
								'avatarPath' => '/upload/avatar/'
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
						
						 'db' =>array(
						 		'class' => 'system.db.CDbConnection',
						 		'autoConnect' => false,
						 		'connectionString' => 'mysql:host=localhost;dbname=lightning',
						 		'emulatePrepare' => true,
						 		'username' => 'root',
						 		'password' => '123456',
						 		'charset' => 'utf8',
						 		'tablePrefix' => 'xcms_'
						 ),
						/*'cache' => array(
								'class' => 'CMemCache',
								'useMemcached' => false,
								'keyPrefix' => 'lightning',
								'useMemcached' => false,
								'servers' => array(
										array(
												//本地memcached缓存
												'host' => 'localhost',
												//阿里云外网IP
//												'host' => '115.29.186.221',
												//阿里云内网IP，本地测试可以使用本地memcached服务器
												//'host' => '10.161.138.206',
												'port' => 11211
										),
								),
						),*/
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
								'rules' => require dirname(__FILE__).'/RestApiRules.php',
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
						'copyright' => '<p>重庆闪电贷金融信息服务有限公司 版权所有 2007-2013<p><p>Copyright Reserved 2007-2013&copy;闪电贷（www.sddai.com） | 渝ICP备05063398号</p>',
						'roleMap' =>array(
								'gxjc' => '工薪阶层',
								'qyz' => '企业主',
								'wddz' => '网店店主',
						),
						'commonUrls' =>array(
								'index' => '/site',
								'useHelp' => '#',
						),
						'bidsPerPage' => 2,//默认的每次请求的标段条数
						
						//标段选择条件参数
						'selectorMap' => array(
								'monthRate' => array(//月利率条件
										'all' => 'all',
										'5%-10%' => ' month_rate between 5 and 10 ',
										'11%-15%' => ' month_rate between 11 and 15 ',
										'16%-20%' => ' month_rate between 16 and 20 ',
								),
								'deadline' => array(//借款期限条件
										'all' => 'all',
										'3-6' => ' deadline between 3 and 6 ',
										'7-9' => ' deadline between 7 and 9 ',
										'10-12' => ' deadline between 10 and 12 ',
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
						'deadline' => array('3-6','7-9','10-12',),
						//认证等级的查询条件
						'authenGrade' => array('AA','AAA','HR',),
				),
		);
	}
}