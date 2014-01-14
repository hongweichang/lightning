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
		<h2>不好意思，您所投资的标段已满标</h2>
		<p>您可以选择其他标段进行投资，请点击下方按钮返回</p>
	</div>
	<div class="hint-button">
		<a href="<?php echo $this->createUrl('purchase'); ?>">返回投资中心</a>
		<a href="<?php echo $this->createUrl('userCenter'); ?>" class="last">个人中心</a>
	</div>
</div>