<?php
/**
 * @name register.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-23 
 * Encoding UTF-8
 */
?>
<form method="post" action="<?php echo $this->createUrl('account/register'); ?>" id="signup">
<?php $this->renderPartial('_error',array('model'=>$model))?>
					<div class="form-item">
						<label for="signup-nickname">昵称</label>
						<input type="text" name="Register[nickname]" class="form-input" id="signup-nickname" value="<?php echo $model->nickname?>" />
						<span class="user-ico"></span>
					</div>
					<div class="form-item">
						<label for="signup-email">邮箱</label>
						<input type="text" name="Register[email]" class="form-input" id="signup-email" value="<?php echo $model->email?>" />
						<span class="user-ico"></span>
					</div>
					<div class="form-item">
						<label for="signup-phone">手机号</label>
						<input type="text" name="Register[mobile]" class="form-input" id="signup-phone" value="<?php echo $model->mobile?>"/>
						<span class="phone-ico"></span>
					</div>
					<div class="form-item">
						<label for="signup-password">密码</label>
						<input type="password" name="Register[password]" class="form-input" id="signup-password" />
						<span class="pw-ico"></span>
					</div>
					<div class="form-item">
						<label for="signup_password_confirm">重复密码</label>
						<input type="password" name="Register[confirm]" class="form-input" id="signup-password-confirm" />
						<span class="pw-ico"></span>
					</div>
					<div class="form-item">
						<label for="signup_verifycode">验证码</label>
						<input type="text" name="Register[code]" class="form-input" id="signup-verifycode" />
						<span class="vc-ico"></span>
						<button id="getVerifycode">获取手机验证码</button>
					</div>
					<div class="form-item clearfix">
						<input type="checkbox" checked="checked" name="Register[protocal]" id="protocal" />
						<div class="fakeCheck">
							<span></span>
						</div>
						<label for="protocal" id="protocal-label">我已阅读并同意<a href="#">《闪电贷网站服务协议》</a></label>
					</div>
					<div class="form-item">
						
						<input type="submit" id="signupBtn" value="注册" />
					</div>
				</form>
