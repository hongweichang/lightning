<?php 
$this->cs->registerCssFile($this->cssUrl.'datepicker.css');
$this->cs->registerCssFile($this->cssUrl.'message.css');
$this->cs->registerScriptFile($this->scriptUrl.'jquery.validate.min.js',CClientScript::POS_END);
$this->cs->registerScriptFile($this->scriptUrl.'datepicker.js',CClientScript::POS_END);
$this->cs->registerScriptFile($this->scriptUrl.'borrow.js',CClientScript::POS_END);
/*$this->cs->registerScript('datepicker',"
$('.input-daterange').datepicker({
	startDate: 'today',
	language: 'zh-CN',    
	todayHighlight: true
});	
",CClientScript::POS_END);*/
?>

<div id="container">
        <div class="wd1002">
            <h1 class="aud-nav">
                <a href="<?php echo $this->createUrl('borrow/index'); ?>">我要借贷 ></a>
                <a><?php echo $role; ?></a>
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
                    <a href="<?php echo $this->app->createUrl('user/userCenter'); ?>">进入个人中心 |</a>
                    <a href="<?php echo $this->app->createUrl('help'); ?>">使用帮助</a>
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
                <form method="post" action="<?php echo $this->createUrl('borrow/info');?>" id="borrow-message">
                    <ul>
                        <li class="message-item">
                        	<label>标段名字:</label>
                         	<input type="text" maxlength="10" name="title" value="<?php echo $form->title; ?>"/>
                            <?php if($form->hasErrors('title')){ ?>
							<p class="message-hint" style="color:red;"><?php echo $form->getError('title'); ?></p>
							<?php } ?>
							<p class="message-hint">
								申请借款的用户需要根据不同的产品提交相应的信用认证材料，经过闪电贷审核后获取相应的信用级及借款额度。
                            </p>
                        </li>
                        <li class="message-item">
                            <label>借款金额:</label>
                            <input type="text" name="sum" value="<?php echo $form->sum; ?>" />
                            <span class="unit">元</span>
                            <?php if($form->hasErrors('sum')){ ?>
							<p class="message-hint" style="color:red;"><?php echo $form->getError('sum'); ?></p>
							<?php } ?>
							<p class="message-hint">
                            	请在此栏填写大于等于1万的借款金额，金额必须是正整数
                            </p>
                        </li>
                        <li class="message-item">
                            <label>年利率:</label>
                            <input type="text" name="rate" value="<?php echo $form->rate; ?>"/>
                            <span class="unit">%</span>
                            <?php if($form->hasErrors('rate')){ ?>
							<p class="message-hint" style="color:red;"><?php echo $form->getError('rate'); ?></p>
							<?php } ?>
                          	<p class="message-hint">
                            	年利率范围在：5% - 20% 之间，请填写您能够接受的借贷利率。
                            </p>
                        </li>
                        <li class="message-item">
                            <label>标段期限:</label>
                            <input type="text" name="deadline" value="<?php echo $form->deadline; ?>"/>
                            <span class="unit">月</span>
                            <?php if($form->hasErrors('deadline')){ ?>
							<p class="message-hint" style="color:red;"><?php echo $form->getError('deadline'); ?></p>
							<?php } ?>
                            <p class="message-hint">
                            	您的借贷将分期付款，请在此栏填写您能够接受的期限，期限不超过36期
                            </p>
                            <div class="message-alert">
                                <p>温馨提示</p>
                                <p>还款方式：等额本息</p>
                                <p>月还本息：￥<span id="calc-borrow-month"></span></p>
                                <p>一次性缴纳服务费：￥<span id="calc-borrow-service"></span>
                                </p>
                                <img src="<?php echo $this->imageUrl;?>message-hint.png" />
                            </div>
                        </li>
                        <li class="message-item">
                            <div class="input-daterange" id="datepicker">
                                <p>
                                    <label>招标开始时间:</label>
                                    <input type="text" class="input-small" name="start" value="<?php echo $form->start; ?>"/>
                                </p>
                                <p><span class="add-on">to</span></p>
                                <p>
                                    <label>招标结束时间:</label>
                                    <input type="text" class="input-small" name="end" value="<?php echo $form->end; ?>"/>
                                </p>
                            </div>
                        </li>
                        <li class="message-item">
                            <label>标段介绍:</label>
                            <textarea name="desc"><?php echo $form->desc; ?></textarea>
                            <span class="placeholder">借款理由、还款保障</span>
                            <?php if($form->hasErrors('desc')){ ?>
							<p class="message-hint" style="color:red;"><?php echo $form->getError('desc'); ?></p>
							<?php } ?>
                        </li>
                    </ul>
                    <!-- data-info为用户对应扣除服务费比例  如2% 则为2 -->
                    <p><input type="submit" value="下一步" id="message-next" data-info="2"  /> </p>
                </form>
            </div>
        </div>
</div>