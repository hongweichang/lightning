<?php
/**
 * @name borrowCalculate.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2014-1-20 
 * Encoding UTF-8
 */
?>
<div class="p2p-calc-content">
                <h1>借款计算器</h1>
                <div class="section">
                    <form action="#" method="post" id="cal-form">
                        <div class="calc-inf">
                                <label for="loan-amount">借款金额</label>
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
                            <label for="loan-deadline">借款期限</label>
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
                            <input type="submit" value="开始计算" id="cal-submit" data-service="<?php echo $userCreditSettings['label'].';'.($userCreditSettings['on_below6']*100).';'.($userCreditSettings['on_over6']*100).';'?>" data-type="borrow" />
                        </div>
                    </form>
                </div>
                <div class="calc-result">
                    <h2>借款描述</h2>
                    <table id="calc-desc">
                        <tbody>
                            <tr>
                                <td>借款金额</td>
                                <td>50元</td>
                                <td>应还利息</td>
                                <td>0.21元</td>
                            </tr>
                            <tr>
                                <td>月还本息</td>
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
                            <?php foreach ( $creditSettings as $creditSetting ):?>
                            <td><?php echo $creditSetting['label']?></td>
                            <?php endforeach;?>
                        </tr>
                        <tr>
                            <td>小于6个月服务费利率</td>
                            <?php foreach ( $creditSettings as $creditSetting ):?>
                            <td><?php echo $creditSetting['on_below6']?>%</td>
                            <?php endforeach;?>
                        </tr>
                        <tr>
                            <td>大于6个月服务费利率</td>
                            <?php foreach ( $creditSettings as $creditSetting ):?>
                            <td><?php echo $creditSetting['on_over6']?>%</td>
                            <?php endforeach;?>
                        </tr>
                        <tr>
                            <td colspan="3">您的会员级别为<span id="calc-rank-show">C</span></td>
                            <td colspan="4">借款一次性扣除服务费金额为<span id="calc-borrow-service">1000</span>元</td>
                        </tr>
                    </table>
                </div>
                <div class="calc-result">
                    <h2>本息偿还时间表</h2>
                    <table id="calc-detail">
                        <tbody>
                            <tr class="calc-detail-title">
                                <td>月份</td>
                                <td>月还本息</td>
                                <td>月还本金</td>
                                <td>月还利息</td>
                                <td>本息余额</td>
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