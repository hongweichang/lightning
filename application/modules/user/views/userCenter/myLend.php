<?php
$this->cs->registerCssFile($this->cssUrl.'common.css');
$this->cs->registerCssFile($this->cssUrl.'detail.css');
?>


    <div id="container">
        <div class="wd989">
            <h1 class="aud-nav">
                <a href="#">个人中心 ></a>
                <a href="#">我的闪电贷</a>
            </h1>
            <?php $this->renderPartial('_baseInfo')?>
            <div class="aud-find aud-find-menu">
                <ul id="find-table-button">
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/myBorrow');?>">
                        <li class="find-table-0"><div class="find-table-op"></div>我的借款</li>
                    </a>
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/myLend');?>">
                        <li class="find-table-1"><div class="find-table-op-hidden"></div>我的投资</li>
                    </a>
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/userSecurity');?>">
                        <li class="find-table-2"><div class="find-table-op"></div>安全中心</li>
                    </a>
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/userInfo');?>">
                        <li class="find-table-3"><div class="find-table-op"></div>个人信息</li>
                    </a>
                    <a href="<?php echo $this->createUrl('userCenter/userFund')?>">
                        <li class="find-table-4"><div class="find-table-op"></div>资金管理</li>
                    </a>
                </ul>
            </div>
            <div class="aud-find">
                <div class="find-table-box find-table-box-show">
                    <div class="tab-border tab-top"></div>
                    <div class="tab-border tab-bottom"></div>
                    <div class="tab-border-l tab-left"></div>
                    <div class="tab-border-l tab-right"></div>
                    <div class="table-content">
                        <div class="tab-content-l">
                            <div class="tab-border-l tab-right"></div>
                            <p>投资总金额<span>0.00<span>元</span></span></p>
                        </div>
                        <div class="tab-content-r">
                            <p><span>投标金额</span><span>收益</span><span>近30天应收益</span></p>
                            <p class="aud-det-money"><span>0.00元</span><span>0.00元</span><span>0.00元</span></p>
                            <p class="aud-det-prompt">您最近10天内有 8笔 投资将收益，总额 0.00元</p>
                        </div>
                    </div>
                </div>
                <ul id="find-table-detail">
                    <li class="find-selected">完成标段</li>
                    <li>正在竞标</li>
                    <li>债权转让</li>
                </ul>
                <div class="find-table-content find-table-content-show">
                    <ul>
                        <li>
                            <span>借款人</span>
                            <span>借款标题</span>
                            <span>年利率</span>
                            <span>还款金额</span>
                            <span>期限</span>
                            <span class="deadline">状态</span>
                            <span class="repay">查看详情</span>
                        </li>
                        <li>
                            <span><img src="#" /></span>
                            <span>再次支持免费充值</span>
                            <span>10.00 % </span>
                            <span>￥25000元</span>
                            <span>3个月</span>
                            <span class="deadline">待转</span>
                            <span class="repay"><a href="">查看</a></span>
                        </li>
                        <li>
                            <span><img src="#" /></span>
                            <span>再次支持免费充值</span>
                            <span>10.00 % </span>
                            <span>￥25000元</span>
                            <span>3个月</span>
                            <span class="deadline">已转</span>
                            <span class="repay"><a href="">查看</a></span>
                        </li>
                    </ul>
                </div>
                <div class="find-table-content">
                    <ul>
                        <li>
                            <span>借款人</span>
                            <span>借款标题</span>
                            <span>年利率</span>
                            <span>投资金额</span>
                            <span>期限</span>
                            <span class="deadline">成立时间</span>
                            <span class="repay">查看详情</span>
                        </li>
                        <?php if(!empty($waitingForBuy)){
                            foreach($waitingForBuy as $value){
                        ?>
                        <li>
                            <span><?php echo $value['nickname'];?></span>
                            <span><?php echo $value['bidTitle'];?></span>
                            <span><?php echo $value['rate'].'%';?></span>
                            <span><?php echo '￥'.$value['sum'].'元'?></span>
                            <span><?php echo $value['deadline']?>个月</span>
                            <span class="deadline"><?php echo $value['buyTime'];?></span>
                            <span class="repay"><a href="">查看</a></span>
                        </li>
                        <?php  }
                            }?>
                    </ul>
                </div>
                <div class="find-table-content">
                    <ul>
                        <li>
                            <span>借款人</span>
                            <span>借款标题</span>
                            <span>年利率</span>
                            <span>还款金额</span>
                            <span>期限</span>
                            <span class="deadline">状态</span>
                            <span class="repay">查看详情</span>
                        </li>
                        <li>
                            <span><img src="#" /></span>
                            <span>再次支持免费充值</span>
                            <span>10.00 % </span>
                            <span>￥25000元</span>
                            <span>3个月</span>
                            <span class="deadline">待转</span>
                            <span class="repay"><a href="">查看</a></span>
                        </li>
                        <li>
                            <span><img src="#" /></span>
                            <span>再次支持免费充值</span>
                            <span>10.00 % </span>
                            <span>￥25000元</span>
                            <span>3个月</span>
                            <span class="deadline">待转</span>
                            <span class="repay"><a href="">查看</a></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php
$this->cs->registerScriptFile($this->scriptUrl.'jquery-1.8.2.min.js',CClientScript::POS_END);
$this->cs->registerScriptFile($this->scriptUrl.'tableChange.js',CClientScript::POS_END);
?>


