<?php
$this->cs->registerScriptFile ( $this->scriptUrl . 'login.js', CClientScript::POS_END );
?>
<div class="wd1002 clearfix">
	<div class="guide">
		<img src="<?php echo $this->imageUrl; ?>guide.png" />
	</div>
	<div id="loginBox">
		<ul class="login-tab clearfix">
			<li id="tab-login"<?php if($isLogin){ ?> class="tab-on"<?php } ?>>登录</li>
			<li id="tab-reg"<?php if(!$isLogin){ ?> class="tab-on"<?php } ?>>快速注册</li>
		</ul>
		<div class="tab-body">
			<div class="tab-content tab-show">
				<?php $this->renderPartial($form,array('model'=>$model))?>
			</div>
		</div>
	</div>
</div>