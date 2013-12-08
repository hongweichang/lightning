<?php
$this->cs->registerScriptFile($this->scriptUrl.'jquery-1.8.2.min.js',CClientScript::POS_END);
$this->cs->registerScriptFile($this->scriptUrl.'jquery.validate.min.js',CClientScript::POS_END);
$this->cs->registerCssFile($this->cssUrl.'common.css');
$this->cs->registerCssFile($this->cssUrl.'detail.css');
?>
<html>
<body>
    <div id="container">
        <div class="wd989">
            <h1 class="aud-nav">
                <a href="#">个人中心 ></a>
                <a href="#">我的闪电贷</a>
            </h1>
            <div class="aud-detail">
                <div class="det-per-inf">
                    <img src="<?php echo $this->imageUrl.'user-avatar.png'?>" class="det-img" />
                    <p>
                        <span class="aud-time">晚上好，</span>
                        <span class="aud-det-name"><?php echo $userData['nickname'];?> </span>
                        现在是属于你自己的时间，好好休息吧
                    </p>
                    <p class="aud-st-serve">
                        <img src="<?php echo $this->imageUrl.'det-person.png'?>" />
                        <img src="<?php echo $this->imageUrl.'det-pro.png'?>" />
                        <img src="<?php echo $this->imageUrl.'det-email.png'?>" />
                        <img src="<?php echo $this->imageUrl.'det-cal.png'?>" />
                        <img src="<?php echo $this->imageUrl.'det-bank.png'?>" />
                        <span>安全等级 :  <span class="det-rank">高</span></span>
                        <span>上次登陆 :  <span class="det-ip"> 重庆市 2013.1116.19:35:35</span></span>
                    </p>
                </div>
                <div class="aud-money">
                    <div class="mon-show">
                        <p>
                            <span>账户余额</span>
                            <span>我的投资</span>
                            <span>我的借贷</span>
                        </p>
                        <p class="det-mon">
                            <span>0.00</span>
                            <span>=</span>
                            <span>0.00</span>
                            <span>+</span>
                            <span class="mon-out">-0.00</span>
                        </p>
                        <div>
                            <a href="#" id="int">充值</a>
                            <a href="#" id="out">提现</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="aud-find">
                <ul id="find-table-button">
                    <a href="">
                        <li class="find-table-0"><div class="find-table-op find-table-op"></div>我的借款</li>
                    </a>
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/myLend');?>">
                        <li class="find-table-1"><div class="find-table-op"></div>我的投资</li>
                    </a>
                    <a href="">
                        <li class="find-table-2"><div class="find-table-op-hidden"></div>安全中心</li>
                    </a>
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/userInfo');?>">
                        <li class="find-table-3"><div class="find-table-op"></div>个人信息</li>
                    </a>
                    <a href="">
                        <li class="find-table-4"><div class="find-table-op"></div>资金管理</li>
                    </a>
                </ul>
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
                            			echo "未设置";
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
                            <form>
                                <div class="form-item">
                                    <label>当前密码</label>
                                    <input type="password" />
                                </div>
                                <div class="form-item">
                                    <label>新密码</label>
                                    <input type="password" />
                                </div>
                                <div class="form-item">
                                    <label>确认密码</label>
                                    <input type="password" />
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
                            <p class="sec-val">绑定邮箱</p>
                            <p class="sec-status">未设置</p>
                            <div class="sec-update">
                                <a href="javascript:;">设置</a>
                            </div>
                        </div>
                        <div class="sec-unfold">
                            <form>
                                <div class="form-item">
                                    <label>当前密码</label>
                                    <input type="password" />
                                </div>
                                <div class="form-item">
                                    <label>新密码</label>
                                    <input type="password" />
                                </div>
                                <div class="form-item">
                                    <label>确认密码</label>
                                    <input type="password" />
                                </div>
                                <div class="form-item">
                                    <input type="submit" class="form-button" value="保存修改"/>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li>
                        <div class="clearfix sec-fold">
                            <div class="sec-img ico-phone"></div>
                            <p class="sec-val">绑定手机</p>
                            <p class="sec-status">136****9982</p>
                            <div class="sec-update">
                                <a href="javascript:;">修改</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="clearfix sec-fold">
                            <div class="sec-img ico-paywd"></div>
                            <p class="sec-val">交易密码</p>
                            <p class="sec-status">已设置</p>
                            <div class="sec-update">
                                <a href="javascript:;">修改 |</a>
                                <a href="javascript:;">找回</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php
$this->cs->registerScriptFile($this->scriptUrl.'/update.js',CClientScript::POS_END);
$this->cs->registerScriptFile($this->scriptUrl.'tableChange.js',CClientScript::POS_END);
?>
</body>
</html>