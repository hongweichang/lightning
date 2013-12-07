<?php
/**
 * file: index.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-25
 * desc: 
 */
$this->cs->registerScriptFile($this->scriptUrl.'lend.js',CClientScript::POS_END);
$this->cs->registerCssFile($this->cssUrl.'lend.css');
?>
      <div class="wd1002">
        <div class="breadcrumb">
          <ul>
            <li class="breadcrumb-item">
              <a href="#">我要投资</a>
            </li>
            <li class="breadcrumb-separator"> >
            </li>
            <li class="breadcrumb-item active">
              <a href="#">投资中心</a>
            </li>
          </ul>
        </div>
        <div id="borrow-info">
          <p id="borrow-brief" class="text-overflow">
          	借款人信息：<?php echo $tender->getRelated('user')->getAttribute('realname'); ?>，
          	借款<?php echo number_format($tender->getAttribute('sum') / 100,2);?>元，
          	月利率<?php echo $tender->getAttribute('month_rate'); ?>%，
          	结束时间<?php echo date('n日H时',$tender->getAttribute('end')); ?>，
          	期限<?php echo $tender->getAttribute('deadline'); ?>个月</p>
          <div id="borrow-details">
            <p>借款人：<?php echo $tender->getRelated('user')->getAttribute('realname'); ?>，<?php echo $tender->getRelated('user')->getAttribute('gender') ? '先生' : '女士'; ?>，<?php echo $tender->getRelated('user')->getAttribute('role'); ?></p>
            <p>身份证号码：<?php $tender->getRelated('user')->getAttribute('identity_id'); ?>,现居地:<?php echo $tender->getRelated('user')->getAttribute('address'); ?></p>
            <p>借款金额：<?php echo number_format($tender->getAttribute('sum') / 100,2);?>元，标段月利率<?php echo $tender->getAttribute('month_rate'); ?>%，期限<?php echo $tender->getAttribute('deadline'); ?>个月，完成<?php echo $tender->getAttribute('progress'); ?>%招募</p>
            <p>招标开始时间：<?php echo date('Y年j月n日H时',$tender->getAttribute('start')); ?>，结束时间：<?php echo date('Y年j月n日H时',$tender->getAttribute('end')); ?></p>
          </div>
          <div id="borrow-num">投标金额：<span><?php echo number_format($sum / 100,2);?>元</span></div>
          <div id="borrow-avatar">
            <img src="<?php echo $this->imageUrl; ?>intro-pic_1.png" />
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
              <div><?php echo $user->getAttribute('nickname'); ?><span><?php echo $user->getAttribute('mobile'); ?></span></div>
            </div>
            <div class="paymethod-item method">
              <input type="radio" checked="checked" name="pay_method" value="ssd" id="pay-ssd"/>
              <label for="pay-ssd">闪电贷账户余额支付</label>
              <span>可支付余额： <?php echo number_format($user->getAttribute('balance') / 100,2); ?>元</span>
              <p class="paycenter-hint question">您需要保证余额足够支付，余额不足可在此充值</p>
            </div>
            <div class="paymethod-item">
              <div class="paymethod-title">选择支付平台</div>
              <div class="paymethod-bank clearfix">
                <ul>
                  <li>
                    <input type="radio" name="pay_bank" value="icbc" id="b-icbc" checked="checked" />
                    <label class="icbc" for="b-icbc"></label>
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