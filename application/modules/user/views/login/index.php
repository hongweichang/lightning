<?php
Yii::app ()->clientScript->registerScriptFile ( $this->scriptUrl . 'login.js', CClientScript::POS_END );
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
			<div class="tab-content<?php if($isLogin) echo ' tab-show'; ?>">
				<form method="post"
					action="<?php echo $this->createUrl('login/index'); ?>" id="login">
					<div class="form-item">
						<input type="text" name="username" class="form-input" />
						<p>请输入手机号/邮箱</p>
						<span class="user-ico"></span>
					</div>
					<div class="form-item">
						<input type="password" name="password" class="form-input" />
						<p>请输入密码</p>
						<span class="pw-ico"></span>
					</div>
					<div class="form-item">
						<input type="checkbox" checked="checked" name="keepSignIn"
							id="keepSignIn" />
						<div class="fakeCheck">
							<span></span>
						</div>
						<label for="keepSignIn">记住用户</label> <a href="#" id="findPw">忘记密码</a>
					</div>
					<div class="form-item">
						<input type="submit" id="loginBtn" value="登录" />
					</div>
				</form>
			</div>
			<div class="tab-content<?php if(!$isLogin) echo ' tab-show'; ?>">
				<form method="post" action="<?php echo $this->createUrl('sign/index'); ?>" id="signup">
					<div class="form-item">
						<label for="signup-username">用户名</label>
						<input type="text" name="username" class="form-input" id="signup-username" value="" />
						<span class="user-ico"></span>
					</div>
					<div class="form-item">
						<label for="signup-phone">手机号</label>
						<input type="text" name="signup_phone" class="form-input" id="signup-phone" />
						<span class="phone-ico"></span>
					</div>
					<div class="form-item">
						<label for="signup-password">密码</label>
						<input type="password" name="signup_password" class="form-input" id="signup-password" />
						<span class="pw-ico"></span>
					</div>
					<div class="form-item">
						<label for="signup_password_confirm">重复密码</label>
						<input type="password" name="signup_password_confirm" class="form-input" id="signup-password-confirm" />
						<span class="pw-ico"></span>
					</div>
					<?php if(CCaptcha::checkRequirements()){ ?>
					<div class="form-item">
						<label for="signup_verifycode">验证码</label>
						<input type="text" name="signup_verifycode" class="form-input" id="signup-verifycode" />
						<span class="vc-ico"></span>
						<?php $this->widget('CCaptcha',array(
							'id' => 'randImage',
							'showRefreshButton' => false,
							'clickableImage' => true,
							'imageOptions' => array(
								'name' => 'randImage',
								'title' => '点击刷新验证码',
								'alt' => '验证码',
							),
						)); ?>
					</div>
					<?php } ?>
					<div class="form-item clearfix">
						<input type="checkbox" checked="checked" name="protocal" id="protocal" />
						<div class="fakeCheck">
							<span></span>
						</div>
						<label for="protocal" id="protocal-label">我已阅读并同意<a href="#">《闪电贷网站服务协议》</a></label>
					</div>
					<div class="form-item">
						
						<input type="submit" id="signupBtn" value="注册" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>