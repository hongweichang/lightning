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
            <div class="aud-detail">
                <div class="det-per-inf">
                   <?php if(!empty($IconUrl)){?>
                    <img src="<?php echo $IconUrl;?>" class="det-img"/>
                    <?php }else{?>
                    <img src="<?php echo $this->imageUrl.'user-avatar.png'?>" class="det-img" />
                    <?php }?>  
                    <p>
                        <span class="aud-time">晚上好，</span>
                        <span class="aud-det-name"><?php echo $userData['nickname'];?> </span>
                        现在是属于你自己的时间，好好休息吧
                    </p>
                    <p class="aud-st-serve">
                        <img src="<?php echo $this->imageUrl.'det-person.png'?>" />
                        <img src="<?php echo $this->imageUrl.'det-pro.png'?>" />
                        <img src="<?php echo $this->imageUrl.'det-email.png'?>" />
                        <img src="<?php echo $this->imageUrl.'det-cal.png'?>" />
                        <img src="<?php echo $this->imageUrl.'det-bank.png'?>" />
                        <span>安全等级 :  <span class="det-rank">高</span></span>
                        <span>上次登陆 :  <span class="det-ip"> 重庆市 2013.1116.19:35:35</span></span>
                    </p>
                </div>
                <div class="aud-money">
                    <div class="mon-show">
                        <p>
                            <span>账户余额</span>
                            <span>我的投资</span>
                            <span>我的借贷</span>
                        </p>
                        <p class="det-mon">
                            <span>0.00</span>
                            <span>=</span>
                            <span>0.00</span>
                            <span>+</span>
                            <span class="mon-out">-0.00</span>
                        </p>
                        <div>
                            <a href="#" id="int">充值</a>
                            <a href="#" id="out">提现</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="aud-find">
                <ul id="find-table-button">
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/myBorrow');?>">
                        <li class="find-table-0"><div class="find-table-op find-table-op"></div>我的借款</li>
                    </a>
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/myLend');?>">
                        <li class="find-table-1"><div class="find-table-op"></div>我的投资</li>
                    </a>
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/userSecurity');?>">
                        <li class="find-table-2"><div class="find-table-op"></div>安全中心</li>
                    </a>
                    <a href="<?php echo Yii::app()->createUrl('user/userCenter/userInfo');?>">
                        <li class="find-table-3"><div class="find-table-op"></div>个人信息</li>
                    </a>
                    <a href="">
                        <li class="find-table-4"><div class="find-table-op-hidden"></div>资金管理</li>
                    </a>
                </ul>
                <div class="find-table-box find-table-box-show fund">
                    <div class="tab-border tab-top"></div>
                    <div class="tab-border tab-bottom"></div>
                    <div class="tab-border-l tab-left"></div>
                    <div class="tab-border-l tab-right"></div>
                    <div class="table-content">
                        <div class="tab-content-l">
                            <div class="tab-border-l tab-right"></div>
                            <p>账户余额<span>0.00<span>元</span></span></p>
                        </div>
                        <div class="tab-content-r">
                            <p>
                                <span>可用资金  0.00元</span>
                                <span>可充值总额  0.00元</span>
                            </p>
                            <p>
                                <span>冻结资金  0.00元</span>
                                <span>可提现总额  0.00元</span>
                            </p>
                        </div>
                    </div>
                </div>
                <ul id="find-table-detail">
                    <li class="find-selected">交易记录</li>
                    <li>充值</li>
                    <li>提现</li>
                </ul>
                <div class="find-table-content fund find-table-content-show">
                    <div id="fund-record-query">
                        <span>查询类型</span>
                        <select>
                            <option value="">所有</option>
                            <option value="">投标成功</option>
                            <option value="">招标成功</option>
                        </select>
                        <span>查询时间</span>
                        <select>
                            <option value="">三天以内</option>
                            <option value="">一周以内</option>
                        </select>
                        <a href="javascript:;" class="form-button">查询</a>
                        <a href="javascript:;" id="export-record">导出查询结果</a>
                    </div>
                    <table class="record-table">
                        <tbody>
                            <tr>
                                <td>时间</td>
                                <td>类型明细</td>
                                <td>收入</td>
                                <td>支出</td>
                                <td>结余</td>
                                <td>备注记录</td>
                            </tr>
                            <tr>
                                <td>2013-12-01 19:30</td>
                                <td>充值</td>
                                <td>1,000,000,000</td>
                                <td>1,000,000,000</td>
                                <td>1,000,000,000</td>
                                <td>德玛西亚！</td>
                            </tr>
                            <tr>
                                <td>2013-12-01 19:30</td>
                                <td>充值</td>
                                <td>1,000,000,000</td>
                                <td>1,000,000,000</td>
                                <td>1,000,000,000</td>
                                <td>德玛西亚！</td>
                            </tr>
                            <tr>
                                <td>2013-12-01 19:30</td>
                                <td>充值</td>
                                <td>1,000,000,000</td>
                                <td>1,000,000,000</td>
                                <td>1,000,000,000</td>
                                <td>德玛西亚！</td>
                            </tr>
                            <tr>
                                <td>2013-12-01 19:30</td>
                                <td>充值</td>
                                <td>1,000,000,000</td>
                                <td>1,000,000,000</td>
                                <td>1,000,000,000</td>
                                <td>德玛西亚！</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="find-table-content fund">
                    <div class="paymethod-bank clearfix">
                        <h2>选择充值方式</h2>
                        <ul>
                          <li>
                            <input type="radio" name="pay_bank" value="icbc" id="b-icbc" />
                            <label class="icbc" for="b-icbc"></label>
                          </li>
                          <li>
                            <input type="radio" name="pay_bank" value="abc" id="b-abc" />
                            <label class="abc" for="b-abc"></label>
                          </li>
                          <li>
                            <input type="radio" name="pay_bank" value="cmb" id="b-cmb" />
                            <label class="cmb" for="b-cmb"></label>
                          </li>
                          <li>
                            <input type="radio" name="pay_bank" value="ccb" id="b-ccb" />
                            <label class="ccb" for="b-ccb"></label>
                          </li>
                          <li>
                            <input type="radio" name="pay_bank" value="boc" id="b-boc" />
                            <label class="boc" for="b-boc"></label>
                          </li>
                          <li>
                            <input type="radio" name="pay_bank" value="post" id="b-post" />
                            <label class="post" for="b-post"></label>
                          </li>
                          <li>
                            <input type="radio" name="pay_bank" value="spdb" id="b-spdb" />
                            <label class="spdb" for="b-spdb"></label>
                          </li>
                          <li>
                            <input type="radio" name="pay_bank" value="cgb" id="b-cgb" />
                            <label class="cgb" for="b-cgb"></label>
                          </li>
                        </ul>
                      </div>
                    <div class="pay-form">
                        <h2>填写充值金额</h2>
                        <form>
                            <ul>
                                <li>
                                    <label>账户余额</label>
                                    <span>0.00</span>
                                    <span>元</span>
                                </li>
                                <li>
                                    <label for="pay-num">充值金额</label>
                                    <input type="text" id="pay-num"/>
                                    <span>元</span>
                                </li>
                                <li>
                                    <label>充值费用</label>
                                    <span>0.00</span>
                                    <span>元</span>
                                </li>
                                <li>
                                    <label>手机号码</label>
                                    <span>156****9658</span>
                                </li>
                                <li>
                                    <label>验证码</label>
                                    <input type="text" class="verifycode"/>
                                    <img src="" id="randImage"/>
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
?>
