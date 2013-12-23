<?php
$this->cs->registerScriptFile($this->scriptUrl.'login.js',CClientScript::POS_END);
$this->cs->registerCssFile($this->cssUrl.'login.css');
?>
<div class="wd1002 clearfix">
	<div class="guide">
		<img src="<?php echo $this->imageUrl; ?>guide.png" />
	</div>
	<div id="loginBox">
		<ul class="login-tab clearfix">
			<?php if ( !$isLogin ):?>
			<a href="<?php echo $this->createUrl('account/login') ?>">
			<?php endif;?>
			<li id="tab-login"<?php if($isLogin){ ?> class="tab-on"<?php } ?>>登录</li>
			<?php if ( !$isLogin ):?>
			</a>
			<?php endif;?>
			
			<?php if ( $isLogin ):?>
			<a href="<?php echo $this->createUrl('account/register') ?>">
			<?php endif;?>
			<li id="tab-reg"<?php if(!$isLogin){ ?> class="tab-on"<?php } ?>>快速注册</li>
			<?php if ( $isLogin ):?>
			</a>
			<?php endif;?>
		</ul>
		<div class="tab-body">
			<div class="tab-content tab-show">
				<?php $this->renderPartial($form,array('model'=>$model,'redirect'=>isset($redirect) ? $redirect : null))?>
			</div>
		</div>
	</div>
</div>