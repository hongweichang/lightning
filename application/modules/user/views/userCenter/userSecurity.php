<?php
$this->cs->registerScriptFile($this->scriptUrl.'jquery-1.8.2.min.js',CClientScript::POS_END);
$this->cs->registerScriptFile($this->scriptUrl.'jquery.validate.min.js',CClientScript::POS_END);
$this->cs->registerCssFile($this->cssUrl.'common.css');
$this->cs->registerCssFile($this->cssUrl.'detail.css');
if(Yii::app()->user->hasFlash('error')){
    $error = Yii::app()->user->getFlash('error');
?>
<script>alert('<?php echo $error;?>');</script>
<?php
}elseif(Yii::app()->user->hasFlash('success')){
    $info = Yii::app()->user->getFlash('success');
?>
<script>alert('<?php echo $info?>');</script>
<?php }?>

    <div id="container">
        <div class="wd989">
            <h1 class="aud-nav">
                <a href="#">个人中心 ></a>
                <a href="#">我的闪电贷</a>
            </h1>
            <?php $this->renderPartial('_baseInfo')?>
            <div class="aud-find">
                <ul id="security-set">
                    <h3>安全设置</h3>
                    <li>
                        <div class="clearfix sec-fold">
                            <div class="sec-img ico-nick"></div>
                            <p class="sec-val">昵称</p>
                            <p class="sec-status">
                            	<?php if($userData->nickname !== null)
                            			echo"已设置";
                            		else
                            			echo"未设置";
                            	?>
                            </p>
                            <div class="sec-update"><?php echo $userData->nickname;?></div>
                        </div>
                    </li>
                    <li>
                        <div class="clearfix sec-fold">
                            <div class="sec-img ico-id"></div>
                            <p class="sec-val">实名认证</p>
                            <p class="sec-status">
                            	<?php
                            		if($userData->identity_id === null)
                            			echo "未认证";
                            		else
                            			echo $userData->identity_id; 
                            	?>
                            </p>
                            <div class="sec-update">
                            	<?php
                            		if($userData->realname === null)
                            			echo "未设置";
                            		else
                            			echo $userData->realname;
                            	?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="clearfix sec-fold">
                            <div class="sec-img ico-pwd"></div>
                            <p class="sec-val">登录密码</p>
                            <p class="sec-status">已设置</p>
                            <div class="sec-update">
                                <a href="javascript:;">修改</a>
                            </div>
                        </div>
                        <div class="sec-unfold">
                            <form name = "passwordChange" method = "post" action = "passwordChange">
                                <div class="form-item">
                                    <label>当前密码</label>
                                    <input type="password" name = "oldPassword"/>
                                </div>
                                <div class="form-item">
                                    <label>新密码</label>
                                    <input type="password" name = "newPassword"/>
                                </div>
                                <div class="form-item">
                                    <label>确认密码</label>
                                    <input type="password"  name = "rePassword"/>
                                </div>
                                <div class="form-item">
                                    <input type="submit" class="form-button" value="保存修改"/>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li> 
                        <div class="clearfix sec-fold">
                           <div class="sec-img ico-mail"></div>
                            <p class="sec-val">邮箱</p>
                            <p class="sec-status">
                            <?php echo $userData->email;?>
                            </p>
                            <div class="sec-update"></div>
                            </div>
                    </li>
                    <li>
                        <div class="clearfix sec-fold">
                            <div class="sec-img ico-phone"></div>
                            <p class="sec-val">绑定手机</p>
                            <p class="sec-status"><?php echo $userData->mobile;?></p>
                        </div>
                    </li>
                    <li>
                        <div class="clearfix sec-fold">
                            <div class="sec-img ico-paywd"></div>
                            <p class="sec-val">交易密码</p>
                            <p class="sec-status">
                                <?php
                                    if(!empty($userData->pay_password)){
                                        echo "已设置";
                                    }else{
                                        echo "未设置"
                                ?>

                            </p>
                            <div class="sec-update">
                                <a href="javascript:;">设置</a>
                            </div>
                        </div>
                        <div class="sec-unfold">
                            <form name = "payPasssword" method = "post" action = "payPasswordCreate">
                                <div class="form-item">
                                    <label>支付密码</label>
                                    <input type="password" name = "password"/>
                                </div>
                                <div class="form-item">
                                    <label>确认密码</label>
                                    <input type="password"  name = "rePassword"/>
                                </div>
                                <div class="form-item">
                                    <input type="submit" class="form-button" value="确认提交"/>
                                </div>
                            </form>
                        </div>
                        <?php }?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php
$this->cs->registerScriptFile($this->scriptUrl.'/update.js',CClientScript::POS_END);
$this->cs->registerScriptFile($this->scriptUrl.'tableChange.js',CClientScript::POS_END);
?>
