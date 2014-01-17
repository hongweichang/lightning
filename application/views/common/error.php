<?php
/**
 * @name error.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2014-1-17 
 * Encoding UTF-8
 */
$this->cs->registerCssFile($this->cssUrl.'pay_hint.css');
?>
<div class="hint-box wait">
	<div class="hint-text">
		<h2>404，您请求的页面找不到了</h2>
		<p>如有疑问，请联系闪电贷客服</p>
	</div>
	<div class="hint-button">
		<a href="<?php echo $this->request->getUrlReferrer(); ?>">返回上一页</a>
		<a href="<?php echo $this->app->homeUrl; ?>" class="last">返回首页</a>
	</div>
</div>