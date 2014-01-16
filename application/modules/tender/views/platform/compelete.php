<?php
/**
 * @file: compelete.php
 * @author: Toruneko<toruneko@outlook.com>
 * @date: 2014-1-14
 * @desc: 
 */
$this->cs->registerCssFile($this->cssUrl.'pay_hint.css');
$this->cs->registerScript("ajax","
setTimeout(function(){
	$.post('".$this->app->createUrl('tender/platform/success')."',{metano:'".$metano."'},function(res){
		if(res.status){
			location.href='".$this->app->createUrl('tender/platform/success')."';
		}else{
			location.href='".$this->app->createUrl('tedder/platform/failure')."';
		}
	});
},3000);
",CClientScript::POS_END);
?>
<div class="hint-box wait">
	<div class="hint-text">
		<h2>请耐心等待支付结果......</h2>
		<p>我们很努力的帮你把现金在交易平台搬来搬去，不要着急哦</p>
		<p>如果很长时间还没有支付成功，请刷新页面或者检查网络</p>
	</div>
	<div class="hint-button">
		<a href="<?php echo $this->app->createUrl('tender/purchase/info',array('id'=>$bid)); ?>">返回详情页</a>
		<a href="<?php echo $this->app->createurl('user/userCenter/myLend'); ?>" class="last">个人中心</a>
	</div>
</div>