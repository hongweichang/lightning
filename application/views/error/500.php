<?php
/**
 * @file: 500.php
 * @author: Toruneko<toruneko@outlook.com>
 * @date: 2014-1-14
 * @desc: 
 */
$this->cs->registerCssFile($this->cssUrl.'pay_hint.css');
?>
<div class="hint-box failed">
	<div class="hint-text">
		<h2>500</h2>
		<p>对不起，系统发生了故障</p>
	</div>
	<div class="hint-button">
		<a href="<?php echo $this->request->getUrlReferrer(); ?>">返回上一页</a>
		<a href="<?php echo $this->app->homeUrl; ?>" class="last">返回首页</a>
	</div>
</div>