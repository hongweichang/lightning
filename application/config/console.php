<?php
/**
 * @name console.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-5 
 * Encoding UTF-8
 */
class console extends ConfigBase{
	public function merge(){
		return array(
				'modules' => array(
						'pay',
						'user',
						'credit',
						'tender',
						'appservice',
						'content',
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
						'application.modules.user.models.*',
						'application.commands.*',
						'cms.components.asyncEvent.zmqCommands.*',//导入zmq命令
				),
				'components' => array(
						'db' => array(
						 		'class' => 'system.db.CDbConnection',
								'autoConnect' => false,
								'connectionString' => 'mysql:host=115.29.173.40;dbname=lightning',
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
						'log'=>array(
								'class'=>'CLogRouter',
								'routes'=>array(
										array(
												'class'=>'CWebLogRoute',
												//'levels'=>'error, warning',
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
								'events' => array(
										'onRegisterSuccess' => array(
												'command' => array('sendMail','test')
										),
								),
						),
				),
				'commandMap' => array(
						'notifyWorkerBroker' => array(
								'class' => 'cms.components.asyncEvent.zmqCommands.Broker',
								'frontendBindAddress' => 'tcp://*:5556',
								'backendBindAddress' => 'tcp://*:5557'
						),
						'notifyWorkerWorker' => array(
								'class' => 'cms.components.asyncEvent.zmqCommands.BrokerEventRouter',
								'brokerAddress' => 'tcp://localhost:5557'
						),
						'sendMail' => array(
								'class' => 'application.commands.SendMailCommand'
						),
						'sendSms' => array(
								'class' => 'application.commands.SendSmsCommand'
						),
						'bid' => array(
								'class' => 'application.commands.BidCommand'
						),
						'logger' => array(
								'class' => 'cms.components.asyncEvent.logging.LoggerCommand'
						),
				),
		);
	}
}