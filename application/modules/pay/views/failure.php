<?php
/**
 * @file: failure.php
 * @author: Toruneko<toruneko@outlook.com>
 * @date: 2014-1-14
 * @desc: 
 */
$this->cs->registerCssFile($this->cssUrl.'pay_hint.css');
?>
<div class="hint-box failed">
	<div class="hint-text">
		<h2><?php echo $title; ?></h2>
		<p>您的充值遇到问题，如有疑问，可以咨询闪电贷客服。</p>
	</div>
	<div class="hint-button">
		<a href="<?php echo $this->app->homeUrl; ?>">返回首页</a>
		<a href="<?php echo $this->createUrl('userCenter'); ?>" class="last">个人中心</a>
	</div>
</div>