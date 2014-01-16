<?php
/**
 * @file: failure.php
 * @author: Toruneko<toruneko@outlook.com>
 * @date: 2014-1-14
 * @desc: 
 */
$this->cs->registerCssFile($this->cssUrl.'pay_hint.css');
$this->cs->registerScript("ajax","
setTimeout(function(){
	location.href='".$this->app->createUrl('user/userCenter/myborrow')."';
},3000);
",CClientScript::POS_END);
?>
<div class="hint-box failed">
	<div class="hint-text">
		<h2>不好意思，您的还款出现了问题</h2>
		<p>您的还款遇到问题，可能是账户余额不足</p>
		<p>请核对您的账户资金，如有疑问，可以咨询闪电贷客服</p>
	</div>
	<div class="hint-button">
		<a href="<?php echo $this->app->homeUrl; ?>">返回首页</a>
		<a href="<?php echo $this->app->createurl('user/userCenter/myborrow'); ?>" class="last">个人中心</a>
	</div>
</div>