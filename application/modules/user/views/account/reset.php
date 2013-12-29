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
					<h2>重置密码</h2>
					<div class="verify-p">
						<p>如果遇到问题，请联系客服<?php echo $this->app['phone']?></p>
					</div>
					<form id="verify-form" method="post">
						<div class="verify-item">
							<label>新密码</label>
							<input type="password" name="password" id="verify-password" class="verify-text-input" />
						</div>
						<div class="verify-item">
							<label>重复密码</label>
							<input type="password" name="repassword" id="verify-password" class="verify-text-input" />
						</div>
						<div class="verify-item">
							<input type="submit" value="完成修改" class="verify-submit" />
						</div>
					</form>
				</div>
			</div>