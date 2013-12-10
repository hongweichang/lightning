<?php $this->cs->registerCssFile($this->cssUrl.'audit.css'); ?>
		<div class="wd1002">
            <h1 class="aud-nav">
                <a href="#">我要借贷 ></a>
                <a href="#">工薪贷 > </a>
                <a href="#">审核 </a>
            </h1>
            <div id="aud-check" class="aud-common">
                <div class="aud-warning">
                    <div class="adu-war-box adu-war-box-first aud-checked">
                        <div class="adu-step"><span>1.填写借款申请</span></div>
                        <span class="adu-next"></span>
                        <div class="adu-bar"></div>
                    </div>
                    <div class="adu-war-box aud-checked">
                        <div class="adu-step"><span>2.填写借款信息</span></div>
                        <span class="adu-next"></span>
                        <div class="adu-bar"></div>
                    </div>
                    <div class="adu-war-box aud-active">
                        <div class="adu-step"><span>3.审核</span></div>
                        <span class="adu-next"></span>
                        <div class="adu-bar"></div>
                    </div>
                    <div class="adu-war-box">
                        <div class="adu-step"><span>4.招标</span></div>
                        <span class="adu-next"></span>
                        <div class="adu-bar"></div>
                    </div>
                    <div class="adu-war-box adu-war-box-last">
                        <div class="adu-step"><span>5.提现</span></div>
                        <div class="adu-bar"></div>
                        <div class="adu-bar adu-bar-last"></div>
                    </div>
                </div>
            </div>
            <div id="aud-detail">
                <div class="aud-ucenter">
                    <a href="<?php echo $this->app->createUrl('user/userCenter/userInfo'); ?>">进入个人中心 |</a>
                    <a href="<?php echo $this->app->createUrl('/help');?>">使用帮助</a>
                </div>
                <div class="aud-warning">
                    <img src="<?php echo $this->imageUrl;?>adu-warning.png" class="adu-img-waring" />
                    <p class="adu-p-warning">您的申请已经提交，我们正在审核之中</p>
                    <div class="aud-link">
                        <a href="<?php echo $this->app->createUrl('user/userCenter/userInfo'); ?>" class="borrow-button">进入个人中心</a>
                        <a href="<?php echo $this->app->homeUrl; ?>" class="borrow-button">返回首页</a>
                    </div>
                </div>
                <h1 class="adu-d-nav"><?php echo $model->title;?></h1>
                <ul>
                    <li>借款金额 :  <span><?php echo $model->sum / 100;?></span>元</li>
                    <li>年利率 :  <span><?php echo $model->month_rate;?></span>%</li>
                    <li>借款期限 :  <span><?php echo $model->deadline;?></span>个月</li>
                    <li>信用等级 :  <span>HR</span></li>
                </ul>
                <ul class="adu-img-bar">
                    <li>
                        <img src="<?php echo $this->imageUrl;?>id-card.png" />
                        <p>身份证正反面</p>
                    </li>
                    <li>
                        <img src="<?php echo $this->imageUrl;?>adu-blank.png" />
                        <p>工资卡存折/银行流水</p>
                    </li>
                    <li>
                        <img src="<?php echo $this->imageUrl;?>adu-believe.png" />
                        <p>个人信用报告</p>
                    </li>
                    <li>
                        <img src="<?php echo $this->imageUrl;?>adu-address.png" />
                        <p>常驻地址证明</p>
                    </li>
                </ul>
                <div class="adu-intro">
                    <h3>【标段介绍】</h3>
                    <p><?php echo $model->description;?></p>
                </div>
            </div>
        </div>

