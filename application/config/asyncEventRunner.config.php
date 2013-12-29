<?php
/**
 * @name asyncEventRunner.config.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-28 
 * Encoding UTF-8
 */
return array(
		'class' => 'cms.components.asyncEvent.AsyncEventRunner',
		'zmqClientId' => 'zmqClient',
		'asyncLogRoutes' => array(
				'accessLog' => array(
						'class' => 'cms.components.asyncEvent.logging.AccessLogRoute'
				),
		),
		'events' => array(
				'onBeforeRegisterSuccess' => array(
						'command' => array('sendSms','verifyCode')
				),
				'onRegisterSuccess' => array(
						'command' => array('sendMail','registerSuccess')
				),
				'onBidVerifySuccess' => array(
						'command' => array('sendSms','bidVerifySuccess')
				),
				'onBidVerifyFailed' => array(
						'command' => array('sendSms','bidVerifyFailed')
				),
				'onPayPurchasedBid' => array(
						'command' => array('bid','pay')
				),
				'onBeforePayBidSuccess' => array(
						'command' => array('sendSms','verifyCode')
				),
				'onResetPassword' => array(
						'command' => array('sendSms','verifyCode')
				),
		),
);