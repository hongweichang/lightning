<?php
/**
 * @name login.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-23 
 * Encoding UTF-8
 */
?>
<form method="post" action="<?php echo $this->createUrl('account/login',array('redirect'=>$redirect)); ?>" id="login">
<?php $this->renderPartial('_error',array('model'=>$model))?>
					<div class="form-item">
						<input type="text" name="Login[account]" class="form-input" value="<?php echo $model->account?>" autocomplete="off" oninput="this.check();" onpropertychange="this.check();"/>
						<p>请输入手机号/邮箱</p>
						<span class="user-ico"></span>
					</div>
					<div class="form-item">
						<input type="password" name="Login[password]" class="form-input" autocomplete="off" oninput="this.check();" onpropertychange="this.check();" />
						<p>请输入密码</p>
						<span class="pw-ico"></span>
					</div>
					<div class="form-item">
						<input type="checkbox" checked="checked" name="Login[rememberMe]"
							id="keepSignIn" />
						<div class="fakeCheck">
							<span></span>
						</div>
						<label for="keepSignIn">记住我</label> <a href="#" id="findPw">忘记密码</a>
					</div>
					<div class="form-item">
						<input type="submit" id="loginBtn" value="登录" />
					</div>
				</form>