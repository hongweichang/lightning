<?php
/**
 * @file: success.php
 * @author: Toruneko<toruneko@outlook.com>
 * @date: 2013-12-5
 * @desc: 
 */
$this->cs->registerCssFile($this->cssUrl.'pay_hint.css');
$this->cs->registerScript("ajax","
setTimeout(function(){
	location.href='".$this->app->createUrl('user/userCenter/myLend')."';
},3000);
",CClientScript::POS_END);
?>
<div class="hint-box success">
	<div class="hint-text">
		<h2>恭喜你，付款已经成功</h2>
		<p>您已成功为所购标段付款，如有疑问，可以咨询闪电贷客服。</p>
		<p>页面3秒钟后会自动跳转，如页面没有反应 可以点击下方按钮</p>
	</div>
	<div class="hint-button">
		<a href="<?php echo $this->app->homeUrl; ?>">返回首页</a>
		<a href="<?php echo $this->app->createurl('user/userCenter/myLend'); ?>" class="last">个人中心</a>
	</div>
</div>