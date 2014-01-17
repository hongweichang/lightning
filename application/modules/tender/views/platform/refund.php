<?php
/**
 * @file: reFund.php
 * @author: Toruneko<toruneko@outlook.com>
 * @date: 2014-1-16
 * @desc: 
 */
$this->cs->registerCssFile($this->cssUrl.'common.css');
$this->cs->registerCssFile($this->cssUrl.'detail.css');
?>
    <div id="container">
        <div class="wd989">
            <div class="aud-find">
                <div class="find-table-content find-table-content-show withdraw">
                    <div class="pay-form">
                        <h2>请填写确认还款</h2>
                        <form id="fund-withdraw" method="post" action="GetCash">
                            <ul>
                                <li>
                                    <label>账户余额</label>
                                    <span class="number"><?php echo number_format($bider->getAttribute('balance') / 100,2); ?></span>
                                    <span>元</span>
                                </li>
                                <li>
                                	<label>还款标段</label>
                                	<span><?php echo $bid->getAttribute('title'); ?></span>
                                </li>
                                <li>
                                	<label>借款金额</label>
                                	<span class="number"><?php echo number_format($bid->getAttribute('sum'),2); ?></span>
                                </li>
                                <li>
                                	<label>年 利 率</label>
                                	<span><?php echo $bid->getAttribute('month_rate') / 100; ?>%</span>
                                </li>
                                <li>
                                	<label>还款期限</label>
                                	<span><?php echo $bid->getAttribute('deadline'); ?>个月</span>
                                </li>
                                <li>
                                    <label>还款金额 </label>
                                    <span class="number"><?php echo number_format($bid->getAttribute('refund') / 100,2); ?></span>
                                    <span>元</span>
                                </li>
                                <li>
                                    <label>资金密码 </label>
                                    <input type="password" id="withdraw-passwd" name="pay_password"/>
                                    <a target="_black" href="<?php echo $this->app->createUrl('user/account/resetPasswordVerify',array('u' => time())); ?>">忘记密码</a>
                                </li>
                                <li>
                                    <input type="submit" value="还款" class="form-button" id="fund-withdraw-submit"/>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>