<?php
$this->cs->registerScriptFile($this->scriptUrl.'jquery-1.8.2.min.js',CClientScript::POS_END);
$this->cs->registerCssFile($this->cssUrl.'common.css');
$this->cs->registerCssFile($this->cssUrl.'calc.css');
$this->cs->registerScriptFile($this->scriptUrl.'jquery.validate.min.js',CClientScript::POS_END);
?>
<html>
<head>
    <meta charset="utf-8" />
    <title>理财计算器</title>
</head>
<body>
    <div id="container">
        <div class="wd1002">
            <div class="p2p-calc-content">
                <h1>理财计算器</h1>
                <div class="section">
                    <form action="#" method="post" id="cal-form">
                        <div class="calc-inf">
                                <label for="loan-amount">借出金额</label>
                            <div class="calc-inf-box">
                                <input type="text" id="loan-amount" name="loan-amount" />
                                <p>元</p>
                            </div>
                                <label for="annual-rate">年利率</label>
                            <div class="calc-inf-box">
                                <input type="text" id="annual-rate" name="annual-rate" />
                                <p>%</p>
                            </div>
                        </div>
                        <div class="calc-inf">
                            <label for="loan-deadline">借出期限</label>
                            <div class="calc-inf-box">
                                <input type="text" id="loan-deadline" name="loan-deadline" />
                                <p>个月</p>
                            </div>
                            <label>还款方式 : 等额本息</label>
                        </div>
                        <div class="calc-inf">
                            <input type="checkbox" id="is-open-time-list" name="is_open" value="open" checked="checked"/>
                            <label for="is-open-time-list">显示还款时间表</label>
                        </div>
                        <div class="calc-inf">
                            <input type="submit" value="开始计算" id="cal-submit" data-service="<?php echo $level.';'.$onLoan?>" data-type="lend" />
                        </div>
                    </form>
                </div>
                <div class="calc-result">
                    <h2>收益描述</h2>
                    <table id="calc-desc">
                        <tbody>
                            <tr>
                                <td>出借金额</td>
                                <td>50元</td>
                                <td>应收利息</td>
                                <td>0.21元</td>
                            </tr>
                            <tr>
                                <td>月收本息</td>
                                <td>50.21元</td>
                                <td colspan="2">您将在1个月后收回全部本息</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="calc-result">
                    <h2>会员级别</h2>
                    <table id="calc-rank">
                        <tr>
                            <td>会员级别</td>
                            <?php foreach($levelData as $value){?>
                            <td><?php echo $value->label;?></td>
                            <?php }?>
                        </tr>
                        <tr>
                            <td>标段利息利润利率</td>
                            <?php foreach($levelData as $value){?>
                            <td><?php echo $value->onLoan.'%';?></td>
                        </tr>
                        <tr>
                            <td colspan="3">您的会员级别为<span id="calc-rank-show"><?php echo $level;?></span></td>
                            <td colspan="4">总共扣除平台管理费<span id="calc-lend-service">1000</span>元</td>
                        </tr>
                    </table>
                </div>
                <div class="calc-result">
                    <h2>本息回收时间表</h2>
                    <table id="calc-detail">
                        <tbody>
                            <tr class="calc-detail-title">
                                <td>月份</td>
                                <td>月收本息</td>
                                <td>月收本金</td>
                                <td>月收利息</td>
                                <td>待收本息</td>
                                <td>月管理费</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <ul class="calc-notify">
                    <li><em>等额本息</em>
                        即借款人每月以相等的金额偿还借款本息，也是银行房贷等采用的方法。因计算中存在四舍五入，最后一期还款金额与之前略有不同。
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php $this->cs->registerScriptFile($this->scriptUrl.'calculator.js',CClientScript::POS_END);?>
</body>
</html>