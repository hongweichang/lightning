<?php
$this->cs->registerCssFile($this->cssUrl.'common.css');
$this->cs->registerCssFile($this->cssUrl.'detail.css');

$this->cs->registerScript("table","
$('.form-button').on('click',function(){
	$.post('".$this->createUrl('userCenter/ajaxFund')."',{type:$('#search-type').val(),date:$('#search-date').val()},function(res){
		$('.record-table tbody').remove();
		$('.record-table .list-view').remove();
		console.log(res);
		$('.record-table').html($('.record-table').html() + res);
	});
});
$('#export-record').on('click',function(){
	$.post('".$this->createUrl('userCenter/ajaxReport')."',{type:$('#search-type').val(),date:$('#search-date').val()},function(res){
		
	});
});
");

if(Yii::app()->user->hasFlash('success')){
    $info = Yii::app()->user->getFlash('success');
?>
<script>alert('<?php echo $info;?>');</script>
<?php }elseif(Yii::app()->user->hasFlash('error')){
    $info = Yii::app()->user->getFlash('error');
?>
<script>alert('<?php echo $info;?>')</script>
<?php }?>
    <div id="container">
        <div class="wd989">
            <h1 class="aud-nav">
                <a href="<?php echo $this->createUrl('userCenter/userFund'); ?>">个人中心 ></a>
                <a href="#">我的闪电贷</a>
            </h1>
            <?php $this->renderPartial('_baseInfo')?>
            <div class="aud-find aud-find-menu">
                <ul id="find-table-button">
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/userInfo');?>">
                        <li class="find-table-3"><div class="find-table-op">个人信息</div></li>
                    </a>
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/myBorrow');?>">
                        <li class="find-table-0"><div class="find-table-op-hidden">我的借款</div></li>
                    </a>
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/myLend');?>">
                        <li class="find-table-1"><div class="find-table-op">我的投资</div></li>
                        </a>
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/userSecurity');?>">
                        <li class="find-table-2"><div class="find-table-op">安全中心</div></li>
                    </a>
                    <a href="<?php echo $this->createUrl('userCenter/userFund')?>">
                        <li class="find-table-4"><div class="find-table-op">资金管理</div></li>
                    </a>
                </ul>
            </div>
            <div class="aud-find">
                <div class="find-table-box find-table-box-show fund">
                    <div class="table-content">
                        <div class="tab-content-l">
                            <div class="tab-border-l tab-right"></div>
                            <p>账户余额<span><?php echo number_format($userData->getAttribute('balance') / 100,2); ?><span>元</span></span></p>
                        </div>
                        <div class="tab-content-r">
                            <p>
                            	<?php $total = $this->app->getModule('tender')->bidManager->getLockBalance($this->user->getId()); ?>
                                <span>总资金  <?php echo number_format($total + $userData->getAttribute('balance') / 100,2); ?>元</span>
                                <span>可用资金  <?php echo number_format($userData->getAttribute('balance') / 100,2); ?>元</span>
                            </p>
                            <p>
                                <span>冻结资金  <?php echo number_format($total,2); ?>元</span>
                                <span>可提现资金  <?php echo number_format($userData->getAttribute('balance') / 100,2); ?>元</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="find-table-content withdraw find-table-content-show">
                    <div class="pay-form">
                        <form id="fund-withdraw" method="post" action="<?php echo $this->createUrl('userCenter/refund',array('bid'=>$bid->getAttribute('id'))); ?>">
                            <ul>
                                <li>
                                    <label>账户余额</label>
                                    <span class="number"><?php echo number_format($userData->balance/100,2);?></span>
                                    <span>元</span>
                                </li>
                                <li>
                                    <label for="withdraw-num">还款金额</label>
                                    <span class="number"><?php echo number_format($bid->getAttribute('refund') / 100,2);?></span>
                                    <span>元</span>
                                </li>                         
                                <li>
                                    <label>待充值</label>
                                    <span class="number" id="userPaySum"><?php 
                                    $pay = $userData->balance - $bid->getAttribute('refund');
                                    if($pay >= 0){
										$pay = 0;
                                    	echo "0.00";
                                    }else{
                                    	$pay = -$pay;
                                    	echo number_format($pay / 100,2);
                                    }
                                    ?></span>
                                    <span>元</span>
                                    <a class="form-button" style="color:#FFF" target="_blank" href="<?php echo $this->createUrl('userCenter/userFund')?>">去充值</a>
                                </li>
                                <li>
                                    <label>结算后余额</label>
                                    <span class="number" id="getSum"><?php 
                                    	echo number_format(($userData->balance - $bid->getAttribute('refund') + $pay) / 100,2);
                                    ?></span>
                                    <span>元</span>
                                </li>
                                <li>
                                    <label>资金密码 </label>
                                    <input type="password" id="withdraw-passwd" name="pay_password"/>
                                    <a href="<?php echo $this->createUrl('account/resetPasswordVerify',array('u'=>strtoupper(md5(time() ))));?>">忘记密码</a>
                                </li>
                                <li>
                                    <input type="submit" value="还款" class="form-button" id="fund-withdraw-submit"/>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
                <div class="find-table-content">
                </div>
            </div>
        </div>
    </div>
<?php
$this->cs->registerScriptFile($this->scriptUrl.'/update.js',CClientScript::POS_END);
$this->cs->registerScriptFile($this->scriptUrl.'tableChange.js',CClientScript::POS_END);
$this->cs->registerScriptFile($this->scriptUrl.'/personal.js',CClientScript::POS_END);
?>
