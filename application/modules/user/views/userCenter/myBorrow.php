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
                <div class="find-table-box find-table-box-show">
                    <div class="table-content">
                        <div class="tab-content-l">
                            <div class="tab-border-l tab-right"></div>
                            <p>借款总金额<span><?php echo $userBidMoney;?><span>元</span></span></p>
                        </div>
                        <div class="tab-content-r">
                            <p><span>逾期金额</span><span>待还金额</span><span>近30天应还金额</span></p>
                            <p class="aud-det-money"><span>0.00元</span><span><?php echo $borrowSum;?>元</span><span><?php echo $borrowSum_month;?>元</span></p>
                            <p class="aud-det-prompt">您最近10天内有 0笔 借款须归还，总额 0.00元</p>
                        </div>
                    </div>
                </div>
                <ul id="find-table-detail">
                    <li class="find-selected">还款中借款</li>
                    <li>已还清借款</li>
                    <li>未满标借款</li>
                </ul>
                <div class="find-table-content find-table-content-show">
                    <ul>
                        <li>
                            <span>借款标题</span>
                            <span>借款金额</span>
                            <span>年利率</span>
                            <span>期限</span>
                            <span>月还款金额</span>
                            <span class="deadline">剩余期数</span>
                            <span class="repay">操作</span>
                        </li>
                        <?php
                            if(!empty($waitingForPay)){ 
                            foreach($waitingForPay as $value){ 
                            ?>
                        <li>
                            <span><?php echo $value[0]['title']; ?></span>
                            <span><?php echo $value[0]['sum']; ?></span>
                            <span><?php echo $value[0]['month_rate']/100;?>%</span>
                            <span><?php echo $value[0]['deadline'].'个月';?></span>
                            <span><?php echo $value[0]['refund']/100;?></span>
                            <span class="deadline"><?php echo $value[0]['repay_deadline'].'个月';?></span>
                            <span class="repay"><?php if($value[0]['verify_progress'] == 31){ ?>
                                <a href="">
                                    <img src="<?php echo $this->imageUrl.'repay.png'?>"/>
                                </a>
                            <?php }else{ ?>
                            	已逾期
                            <?php } ?>
                            </span>
                        </li>
                        <?php 
                        }
                            }?> 
                    </ul>
                
                </div>
                <div class="find-table-content">
                    <ul>
                        <li>
                            <span>借款标题</span>
                            <span>借款金额</span>
                            <span>年利率</span>
                            <span>期限</span>
                            <span>月还款金额</span>
                            <span class="deadline">还清时间</span>
                            <span class="repay">操作</span>
                        </li>
                        <?php foreach($finished as $value){?>
                        <li>
                            <span><?php echo $value[0]['title'];?></span>
                            <span><?php echo $value[0]['sum']; ?></span>
                            <span><?php echo $value[0]['month_rate']/100;?>%</span>
                            <span><?php echo $value[0]['deadline'].'个月';?></span>
                            <span><?php echo $value[0]['refund']/100;?></span>
                            <span class="deadline"><?php echo date('Y:m:d H:i:s',$value[0]['finish_time']);?></span>
                            <span class="repay"></span>
                        </li>
                        <?php }?>
                    </ul>
                </div>
                <div class="find-table-content">
                    <ul>
                        <li>
                            <span>借款标题</span>
                            <span>借款金额</span>
                            <span>年利率</span>
                            <span>期限</span>
                            <span>月还款金额</span>
                            <span class="deadline">状态</span>
                            <span class="repay">操作</span>
                        </li>
                        <?php
                            if(!empty($waitingForBuy)){
                                foreach($waitingForBuy as $value){
                        ?>
                         <li>
                            <span><?php echo $value[0]['title'];?></span>
                            <span><?php echo $value[0]['sum']; ?></span>
                            <span><?php echo $value[0]['month_rate']/100;?>%</span>
                            <span><?php echo $value[0]['deadline'].'个月'?></span>
                            <span><?php echo $value[0]['sum']/100;?></span>
                            <span class="deadline">
                            <?php
                                if($value[0]['verify_progress'] == 11)
                                    echo "正在审核";
                                elseif($value[0]['verify_progress'] == 20)
                                    echo "审核未通过";
                                elseif($value[0]['verify_progress'] == 21)
                                    echo "正在投标";
                                elseif($value[0]['verify_progress'] == 30)
                                	echo "已流标"
                            ?>
                            </span>
                            <?php if($value[0]['verify_progress'] == 21){ ?>
                            <span class="repay"><a href="<?php echo Yii::app()->createUrl('tender/purchase/info/',array('id'=>$value[0]['id']))?>">查看</a></span>
                            <?php }?>
                        </li>         
                        <?php }
                            } 
                        ?>
                       
                    </ul>
                </div>
            </div>
        </div>
    </div>

<?php
$this->cs->registerScriptFile($this->scriptUrl.'jquery-1.8.2.min.js',CClientScript::POS_END);
$this->cs->registerScriptFile($this->scriptUrl.'tableChange.js',CClientScript::POS_END);
?>
