<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="renderer" content="webkit"> 
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <script type="text/javascript" src="<?php echo $this->scriptUrl; ?>jquery-1.8.2.min.js"></script>
    <script type="text/javascript">
     var baseUrl = '<?php echo $this->app->getSiteBaseUrl();?>';
     $(".f-wx").on("click",function(){
        $("#mask").fadeIn();
        $("#two-dim-code").css({
            left:($(window).width() - $('#two-dim-code').outerWidth())/2,
            top: ($(window).height() - $('#two-dim-code').outerHeight())/2 + $(document).scrollTop()
        }).fadeIn();
     });
     $('#mask').on('click',function(){
        $('#mask').fadeOut();
        $('#two-dim-code').fadeOut();
    });
    </script>
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->cssUrl?>ie.css">
    <![endif]-->
</head>
<body>
<!--[if lt IE 8]>
    <div class="attention">
            <ul class="btn">
                <li class="dn"><a href="http://hr.bingyan.net/info/download/form.doc" target="_blank"></a></li>
                <li class="pcd"><a href="http://hr.bingyan.net/info/flow.html" target="_blank"></a></li>
            </ul>
            <h1>闪电贷</h1>
            <p class="sry">We are so sorry, but……</p>
            <p class="explain">你的浏览器版本过低，无法看到我的全身-n-! 快升级你的浏览器吧<br>如果你使用的是360浏览器或搜狗浏览器，切换到<span>高速模式</span>就可以看到！</p>
            <div class="rec">
                <h4>推荐浏览器</h4>
                <span class="brss chr"><a href="http://www.google.com/chrome" target="_blank" title="谷歌浏览器">谷歌浏览器</a></span>
                <span class="brss fir"><a href="http://firefox.com.cn/download/" target="_blank" title="火狐浏览器">火狐浏览器</a></span>
            </div>
            <p class="no-upgrd">
                如果你暂时不想升级，也可以从这里获得信息<br>
                <a href="http://theie6countdown.cn/" target="_blank">
                    对IE6/7说再见吧！
                </a>
            </p>
        </div>
<![endif]-->
    <div id="mask"></div>
    <div id="two-dim-code"><img src="<?php echo $this->imageUrl; ?>qrcode.jpg" /><p>微信号：shandiandai8</p></div>
    <div id="header">
    
      <div id="he-login">
        <div class="wd1002">
        <?php if ( $this->user->getIsGuest() === true ):?>
            <p class="he-lo">
              <a href="<?php echo $this->createUrl('/user/account/login')?>">登录</a>
              <a href="<?php echo $this->createUrl('/user/account/register')?>">注册中心</a>
              <a href="<?php echo $this->createUrl('/content/help')?>">帮助中心</a>
            </p>
            <p class="he-wl">您好，欢迎你来到闪电贷！</p>
      <?php else:?>
           <p class="he-lo">
              <a href="<?php echo $this->createUrl('/user/account/logout')?>">退出</a>
              <a href="<?php echo $this->createUrl('/content/help')?>">帮助中心</a>
            </p>
            <p class="he-wl">您好 <?php echo $this->user->getName()?>，欢迎你来到闪电贷！</p>
      <?php endif;?>
        </div>
      </div>
      <div id="he-nav">
        <div class="wd1002">
          <a href="<?php echo $this->app->createUrl('/site')?>"><img src="<?php echo $this->imageUrl; ?>logo.png" id="logo" /></a>
          <ul>
            <li class="origin"><a href="<?php echo $this->app->homeUrl; ?>">首页</a></li>
            <li class="yellow"><a href="<?php echo $this->app->createUrl('tender/borrow'); ?>">我要借款</a></li>
            <li class="green"><a href="<?php echo $this->app->createUrl('tender/purchase'); ?>">我要投资</a></li>
            <!-- <li class="deepGreen"><a href="#">债权转让</a></li>-->
            <li class="pink"><a href="<?php echo $this->createUrl('/content/aboutus')?>">关于我们</a></li>
            <li class="violet"><a href="<?php echo $this->app->createUrl('user/userCenter/userInfo'); ?>">个人中心</a></li>
          </ul>
        </div>
      </div>
    </div>
   <div id="container">
    <?php echo $content; ?>
    </div>
    <div id="footer">
      <div class="wd1002 clearfix">
            <div class="footer-contact">
                <p>客服电话</p>
                <p>023-63080933</p>
                <p>9:00-21:00</p>
            </div>
            <div class="footer-sec clearfix">
                <ul>
                    <li><a href="<?php echo $this->createUrl('/content/aboutus/index',array('cid'=>28))?>">公司介绍</a></li>
                    <li><a href="<?php echo $this->createUrl('/content/help/index',array('cid'=>17))?>">借款说明</a></li>
                    <li><a href="<?php echo $this->createUrl('/content/help/index',array('cid'=>18))?>">理财说明</a></li>
                    <li><a href="<?php echo $this->createUrl('/content/help')?>">帮助中心</a></li>
                    <li><a href="<?php echo $this->createUrl('/site/guide')?>">新手引导</a></li>
                    <li><a href="<?php echo $this->createUrl('/content/aboutus/index',array('cid'=>26))?>">联系我们</a></li>
                    <li><a href="#">万兆投资</a></li>
                    <li><a href="<?php echo $this->createUrl('/content/help/index',array('cid'=>24))?>">常见问题</a></li>
                </ul>
            </div>
            <div class="footer-sec clearfix">
                <ul>
                    <li class="f-text">关注我们</li>
                    <li><a href="http://weibo.com/u/3963075906" class="f-img" id="f-wb"></a></li>
                    <li><a href=""  class="f-img" id="f-tx" onclick="alert('马上上线，敬请期待')"></a></li>
                    <li><a href=""  class="f-img f-wx" id="f-wx"></a></li>
                </ul>
            </div>
            <div class="footer-sec">
            	<p>免责声明：本网站只提供资金需求信息，以促成双方达成交易为目的并从中收取一定管理费，不提供资金担保以及本金保障服务，特此声明</p>
            </div>
            <div class="footer-sec clearfix last">
                <div id="f-copyright">
                    <span>渝ICP备13008004号 |</span>
                    <span>© 2013-2014 重庆万兆投资有限公司  All rights reserved | </span>
                    <span>闪电贷</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>