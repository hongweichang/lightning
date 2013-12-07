<?php $this->cs->registerCssFile($this->cssUrl.'datepicker.css'); ?>
<?php $this->cs->registerCssFile($this->cssUrl.'message.css'); ?>
<?php $this->cs->registerScriptFile($this->scriptUrl.'jquery.validate.min.js',CClientScript::POS_END);?>
<?php $this->cs->registerScriptFile($this->scriptUrl.'datepicker.js',CClientScript::POS_BEGIN);?>

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
                <form method="post" action="<?php echo $this->createUrl($data['postUrl']);?>" id="borrow-message">
                    <ul>
                        <li class="message-item">
                                <label>标段名字:</label>
                                <input type="text" maxlength="10" name="writeBidInfoForm[title]" />
                            <p class="message-hint">申请借款的用户需要根据不同的产品提交相应的信用认证材料，经过闪电贷审核后获取相应的信用级及借款额度。</p>
                        </li>
                        <li class="message-item">
                            <label>借款金额:</label>
                            <input type="text" name="writeBidInfoForm[sum]" />
                            <span class="unit">元</span>
                        </li>
                        <li class="message-item">
                            <label>标段利率:</label>
                            <input type="text" name="writeBidInfoForm[month_rate]" />
                            <span class="unit">%</span>
                        </li>
                        <li class="message-item">
                            <label>标段期限:</label>
                            <input type="text" name="writeBidInfoForm[deadline]" />
                            <span class="unit">月</span>
                        </li>
                        <li class="message-item">
                            <div class="input-daterange" id="datepicker">
                                <p>
                                    <label>招标开始时间:</label>
                                    <input type="text" class="input-small" name="writeBidInfoForm[start]" />
                                </p>
                                <p><span class="add-on">to</span></p>
                                <p>
                                    <label>招标结束时间:</label>
                                    <input type="text" class="input-small" name="writeBidInfoForm[end]" />
                                </p>
                            </div>
                        </li>
                        <li class="message-item">
                            <label>标段介绍:</label>
                            <textarea name="writeBidInfoForm[description]"></textarea>
                        </li>
                    </ul>
                    <p><input type="submit" value="下一步" name="writeBidInfoForm[submitBtn]" id="message-next"  /> </p>
                </form>
            </div>
        </div>
<script type="text/javascript">
	$('.input-daterange').datepicker({
		startDate: "today",
	    language: "zh-CN",    
	    todayHighlight: true
	});
</script>
