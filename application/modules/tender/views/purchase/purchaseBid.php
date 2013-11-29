<?php $this->cs->registerCssFile($this->cssUrl.'lend.css'); ?>
<div class="wd1002">
        <div class="breadcrumb">
          <ul>
            <li class="breadcrumb-item">
              <a href="#">我要投资</a>
            </li>
            <li class="breadcrumb-separator"> 
            </li>
            <li class="breadcrumb-item active">
              <a href="#">投资中心</a>
            </li>
          </ul>
        </div>
        <div id="borrow-info">
          <p id="borrow-brief" class="text-overflow">借款人信息：王果冻，借款10000元，月利率10%，结束时间19日23点，期限3个月期限3个月</p>
          <div id="borrow-details">
            <p>借款人：王国栋，男，淘宝主</p>
            <p>身份证号码：**************,现居地:重庆南岸</p>
            <p>借款金额：10000元，标段月利率10%，期限3个月，完成30%招募</p>
            <p>招标开始时间：2013年16日0点，结束时间：2013年19日23点</p>
          </div>
          <div id="borrow-num">投标金额：<span>1,000元</span></div>
          <div id="borrow-avatar">
            <img src="../images/intro-pic_1.png" />
            <span>信</span>
          </div>
        </div>
        <div id="view-detail"></div>
        <div class="paycenter paymethod">
          <form method="post" action="#" id="pay-method">
            <div class="paymethod-item userinfo">
              <div class="paymethod-manage">
                <a href="#">管理我的账户 |</a>
                <a href="#">使用帮助</a>
              </div>  
              <div>王国栋<span>15683128505</span></div>
            </div>
            <div class="paymethod-item method">
              <input type="radio" checked="checked" name="pay_method" value="ssd" id="pay-ssd"/>
              <label for="pay-ssd">闪电贷账户余额支付</label>
              <span>可支付余额： 0.00元</span>
              <p class="paycenter-hint question">您需要保证余额足够支付，余额不足可在此<a href="#">充值</a></p>
            </div>
            <div class="paymethod-item">
              <div class="paymethod-title">使用银行卡支付</div>
              <div class="paymethod-bank clearfix">
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
            </div>
            <div>
              <input type="submit" value="下一步" class="paycenter-button" id="paycenter-next"/>
            </div>
          </form>
        </div>
        <div id="helpcenter">
          <h3>充值时遇到的问题</h3>
          <p class="help-title">1. 我可以如何充值？没有第三方支付的账户是否也可以充值？</p>
          <p class="help-answer">答：您在"我的账户"首页可看到"充值"按钮，点击充值，会自动弹出充值页面，按照操作提示一步步进行即可。</p>
          <p class="help-title">2. 为什么网上银行充值成功，但是闪电贷帐号里面的余额却没有增加？</p>
          <p class="help-answer">答：由于在同一时间使用同一个第三方充值账户端口充值的人可能非常多，在某些时候会造成网银显示与闪电贷
账号金额不同步的情况。如果遇到这种情况请您将网银付款成功的页面截图，然后刷新闪电贷账户页面。如果刷
新未能解决问题，请您致电客服400 890 3890，客服专员会指导发送截图并马上处理您的问题。</p>
          <a href="#">更多帮助</a>
          <a href="#">进入闪电贷账户</a>
        </div>
      </div>
