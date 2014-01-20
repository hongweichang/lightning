<div class="wd1002 clearfix">
				<div id="verify">
				<div class="verify-p">
						<p>如果遇到问题，请联系客服<?php echo $this->app['phone']?></p>
					</div>
						<div class="success-item">
							<label>修改成功，请使用新密码。</label>
						</div>
						<div class="success-item">
							<label>您现在可以</label>
						</div>
						<div class="success-item">
							<a href="<?php echo $this->createUrl('account/login')?>" class="goback">登录</a>
							<a href="<?php echo $this->createUrl('/site')?>" class="goback">返回首页</a>
						</div>
				</div>
			</div>