<?php $this->cs->registerCssFile($this->cssUrl.'message.css'); ?>
        <div class="wd1002">
            <h1 class="aud-nav">
                <a href="#">我要借贷 ></a>
                <a href="#">工薪贷 > </a>
                <a href="#">填写借款信息 </a>
            </h1>
            <div id="aud-check" class="aud-common">
                <div class="aud-warning">
                    <div class="adu-war-box adu-war-box-first aud-checked">
                        <div class="adu-step"><span>1.填写借款申请</span></div>
                        <span class="adu-next"></span>
                        <div class="adu-bar"></div>
                    </div>
                    <div class="adu-war-box aud-active">
                        <div class="adu-step"><span>2.填写借款信息</span></div>
                        <span class="adu-next"></span>
                        <div class="adu-bar"></div>
                    </div>
                    <div class="adu-war-box">
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
            <div class="adu-detail clearfix">
                <div class="aud-ucenter">
                    <a href="<?php echo $this->createUrl($data['userCenter']); ?>">进入个人中心 |</a>
                    <a href="<?php echo $this->createUrl($data['help']); ?>">使用帮助</a>
                </div>
                <div class="adu-progress">
                    <ul>
                        <li>
                            <img src="<?php echo $this->imageUrl;?>progress_c.png" />
                            NAME
                        </li>
                        <li>
                            <img src="<?php echo $this->imageUrl;?>progress_c.png" />
                            MONEY
                        </li>
                        <li>
                            <img src="<?php echo $this->imageUrl;?>progress_c.png" />
                            RATE
                        </li>
                        <li>
                            <img src="<?php echo $this->imageUrl;?>progress_c.png" />
                            DEADLINE
                        </li>
                        <li>
                            <img src="<?php echo $this->imageUrl;?>progress_c.png" />
                            TIME
                        </li>
                        <li>
                            <img src="<?php echo $this->imageUrl;?>progress_c.png" />
                            INTRODUCTION
                        </li>
                    </ul>
                </div>
                <form method="post" action="<?php echo $this->createUrl($data['postUrl']); ?>" id="borrow-message">
                    <ul>
                        <li class="message-item">
                            <div>
                                <label>标段名字:</label>
                                <input type="text" name="writeBidInfoForm[title]" maxlength="4" />
                            </div>
                        </li>
                        <li class="message-item">
                            <label>借款金额:</label>
                            <input type="text" name="writeBidInfoForm[sum]" />
                        </li>
                        <li class="message-item">
                            <label>标段利率:</label>
                            <input type="text" name="writeBidInfoForm[month_rate]" />
                        </li>
                        <li class="message-item">
                            <label>标段期限:</label>
                            <input type="text" name="writeBidInfoForm[deadline]" />
                        </li>
                        <li class="message-item">
                            <label>提交:</label>
                            <input type="submit" name="writeBidInfoForm[submitBtn]" value="下一步" />
                        </li>
                    </ul>
                </form>
            </div>
        </div>
