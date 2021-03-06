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
				'onCreditVerifySuccess' => array(
						'command' => array('sendSms','creditVerifySuccess')
				),
				'onCreditVerifyFailed' => array(
						'command' => array('sendSms','creditVerifyFailed')
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
				'onResetPayPassword' => array(
						'command' => array('sendSms','verifyCode')
				),
				'onRepay' => array(//催款通知
						'command' => array('sendSms','repay'),
				),
				'onRepayDelay' => array(//还款逾期未操作
						'command' => array('sendSms','bidMessage')
				),
				'onRevokeBid' => array(//流标
						'command' => array('sendSms','bidMessage')
				),
				'onCompeleteBid' => array(//满标
						'command' => array('sendSms','bidMessage')
				)
		),
);