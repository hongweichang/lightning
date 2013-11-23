<?php
/**
 * @name register.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-23 
 * Encoding UTF-8
 */
?>
<form method="post" action="<?php echo $this->createUrl('sign/index'); ?>" id="signup">
					<div class="form-item">
						<label for="signup-nickname">昵称</label>
						<input type="text" name="signup_nickname" class="form-input" id="signup-nickname" value="" />
						<span class="user-ico"></span>
					</div>
					<div class="form-item">
						<label for="signup-email">邮箱</label>
						<input type="text" name="signup_email" class="form-input" id="signup-email" value="" />
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
