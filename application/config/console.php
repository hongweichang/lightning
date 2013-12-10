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
						'pay' => array(
								'class' => 'application.modules.pay.PayModule'
						),
						'admin' => array(
							'class' => 'application.modules.admin.AdminModule'
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
						'application.modules.user.models.*',
						'cms.components.asyncEvent.zmqCommands.*',//导入zmq命令
				),
				'components' => array(
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
						'notifyWorkerRouter' => array(
								'class' => 'cms.components.asyncEvent.zmqCommands.BrokerEventRouter',
								'brokerAddress' => 'tcp://localhost:5557'
						),
						'sendMail' => array(
								'class' => 'application.commands.SendMailCommand'
						),
				),
		);
	}
}