<!DOCTYPE html>
<html xmlns:wb="http://open.weibo.com/wb">
<head>
    <meta charset="UTF-8" />
    <meta name="renderer" content="webkit"> 
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <script type="text/javascript" src="<?php echo $this->scriptUrl; ?>jquery-1.8.2.min.js"></script>
    <script type="text/javascript">
     var baseUrl = '<?php echo $this->app->getSiteBaseUrl();?>';
</script>
    <script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>  
</head>
<body>
    <div id="header">
    
      <div id="he-login">
        <div class="wd1002">
        <wb:follow-button uid="3315582810" type="red_2" width="136" height="24" id="he-wb" ></wb:follow-button>
        <?php if ( $this->user->getIsGuest() === true ):?>
            <p class="he-lo">
              <a href="<?php echo $this->createUrl('/user/account/login')?>">登录</a>
              <a href="<?php echo $this->createUrl('/user/account/register')?>">注册中心</a>
              <a href="<?php echo $this->createUrl('/content/help')?>">帮助中心</a>
              <!-- <a href="#"><img src="<?php echo $this->imageUrl; ?>top-bg.png" />关注闪电贷微博</a> -->
            </p>
            <p class="he-wl">您好，欢迎你来到闪电贷！</p>
      <?php else:?>
           <p class="he-lo">
              <a href="<?php echo $this->createUrl('/user/account/logout')?>">退出</a>
              <a href="<?php echo $this->createUrl('/content/help')?>">帮助中心</a>
              <!-- <a href="#"><img src="<?php echo $this->imageUrl; ?>top-bg.png" />关注闪电贷微博</a> -->
              <wb:follow-button uid="3315582810" type="red_2" width="136" height="24" ></wb:follow-button>
            </p>
            <p class="he-wl">您好 <?php echo $this->user->getName()?>，欢迎你来到闪电贷！</p>
      <?php endif;?>
        </div>
      </div>
      <div id="he-nav">
        <div class="wd1002">
          <a href="<?php echo $this->createUrl('/')?>"><img src="<?php echo $this->imageUrl; ?>logo.png" id="logo" /></a>
          <ul>
            <li class="origin"><a href="<?php echo $this->app->homeUrl; ?>">首页</a></li>
            <li class="yellow"><a href="<?php echo $this->app->createUrl('tender/borrow'); ?>">我要借款</a></li>
            <li class="green"><a href="<?php echo $this->app->createUrl('tender/purchase'); ?>">我要投资</a></li>
            <li class="deepGreen"><a href="#">债券转让</a></li>
            <li class="pink"><a href="<?php echo $this->createUrl('/content/help/index',array('cid'=>2))?>">关于我们</a></li>
            <li class="violet"><a href="<?php echo $this->app->createUrl('user/userCenter/userInfo'); ?>">个人中心</a></li>
          </ul>
        </div>
      </div>
    </div>
   <div id="container">
    <?php echo $content; ?>
    </div>
    <div id="footer">
      <!-- <div class="wd1002">
        <ul id="fo-nav">
          <li><img src="<?php echo $this->imageUrl; ?>wl.png" />新手入门
            <ul>
              <li><a href="#">免费注册</a></li>
              <li><a href="#">我的闪电袋</a></li>
              <li><a href="#">如何借入</a></li>
            </ul>
          </li>
          <li><img src="<?php echo $this->imageUrl; ?>out.png" />我要借出
            <ul>
              <li><a href="#">浏览借款</a></li>
              <li><a href="#">自动投票</a></li>
              <li><a href="#">成为VIP</a></li>
            </ul>
          </li>
          <li><img src="<?php echo $this->imageUrl; ?>int.png" />我要借入
            <ul>
              <li><a href="#">发布借款</a></li>
              <li><a href="#">优先计划</a></li>
              <li><a href="#">诚信认证</a></li>
            </ul>
          </li>
          <li><img src="<?php echo $this->imageUrl; ?>belief.png" />诚信保障
            <ul>
              <li><a href="#">本金保障</a></li>
              <li><a href="#">法律政策</a></li>
            </ul>
          </li>
          <li><img src="<?php echo $this->imageUrl; ?>about_p2p.png" />关于闪电贷
            <ul>
              <li><a href="#">闪电贷团队</a></li>
              <li><a href="#">闪电贷论坛</a></li>
              <li><a href="#">媒体报道</a></li>
              <li><a href="#">招贤纳士</a></li>
            </ul>
          </li>
          <li><img src="<?php echo $this->imageUrl; ?>about.png" />关于我们
            <ul>
              <li><a href="#">新浪微博</a></li>
              <li><a href="#">腾讯微博</a></li>
            </ul>
          </li>
        </ul>
        <div id="fo-contact">
          <img src="<?php echo $this->imageUrl; ?>phone-ico.png" />
          <p><span class="con-number">400-181-081</span>
              (工作日：9:30-11:30 13:00-17:30)</p>
          <div class="con-center">
              <a href="#"><img src="<?php echo $this->imageUrl; ?>con-img_0.png" /></a>
              <a href="#"><img src="<?php echo $this->imageUrl; ?>con-img_1.png" /></a>
              <a href="#"><img src="<?php echo $this->imageUrl; ?>con-img_4.png" /></a>
              <a href="#"><img src="<?php echo $this->imageUrl; ?>con-img_3.png" /></a>
              <a href="#"><img src="<?php echo $this->imageUrl; ?>con-img_2.png" /></a>
          </div>
        </div>
        <div id="copyright">
            <?php echo $this->app['copyright']?>
        </div>
      </div> -->
      <div class="wd1002 clearfix">
            <div class="footer-contact">
                <p>客服电话</p>
                <p>023-63080933</p>
                <p>9:00-21:00</p>
            </div>
            <div class="footer-sec clearfix">
                <ul>
                    <li><a href="#">公司介绍</a></li>
                    <li><a href="#">借款说明</a></li>
                    <li><a href="#">投资说明</a></li>
                    <li><a href="#">帮助中心</a></li>
                    <li><a href="#">联系我们</a></li>
                    <li><a href="#">万兆投资</a></li>
                    <li><a href="#">常见问题</a></li>
                </ul>
            </div>
            <div class="footer-sec clearfix">
                <ul>
                    <li class="f-text">关注我们</li>
                    <li><a href="" class="f-img" id="f-wb"></a></li>
                    <li><a href=""  class="f-img" id="f-tx"></a></li>
                    <li><a href=""  class="f-img" id="f-wx"></a></li>
                </ul>
            </div>
            <div class="footer-sec clearfix last">
                <div id="f-copyright">
                    <span>渝ICP备13008004号 |</span>
                    <span>© 2013-2014 重庆万兆投资有限公司  All rights reserved|</span>
                    <span>闪电贷</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>