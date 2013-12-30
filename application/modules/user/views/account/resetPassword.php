<?php
/**
 * @name resetPassword.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-28 
 * Encoding UTF-8
 */
?>
<div class="wd1002 clearfix">
				<div id="verify">
					<h2><?php echo $resetName;?></h2>
					<div class="verify-p">
						<p>手机号是您在闪电贷理财借款的重要安全凭证。</p>
						<p>为了确保您的帐号安全，我们将同时验证您的昵称和手机是否匹配</p>
						<p>如果遇到问题，请联系客服<?php echo $this->app['phone']?></p>
					</div>
					<form id="verify-form" method="post">
						<div class="verify-item">
							<label>昵称</label>
							<input type="text" name="Verify[nickname]" id="verify-nickname" class="verify-text-input" />
						</div>
						<div class="verify-item">
							<label>手机号</label>
							<input type="text" name="Verify[mobile]" id="verify-mobile" class="verify-text-input" />
						</div>
						<div class="verify-item">
							<label>手机验证码</label>
							<input type="text" name="Verify[code]" id="verify-code" class="verify-text-input"  />
							<button data-url="<?php echo $this->createUrl('account/sendResetVerify')?>" id="getVerifyCodeButton">获取验证码</button>
						</div>
						<div class="verify-item">
							<input type="submit" value="下一步" class="verify-submit" />
						</div>
					</form>
				</div>
			</div>