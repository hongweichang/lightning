<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="renderer" content="webkit"> 
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <script type="text/javascript" src="<?php echo $this->scriptUrl; ?>jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->scriptUrl; ?>jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->scriptUrl; ?>login.js"></script>
    <script type="text/javascript">
     var baseUrl = '<?php echo $this->app->getSiteBaseUrl();?>';
</script>  
</head>
<body>
    <div id="header">
    
      <div id="he-login">
        <div class="wd1002">
        <wb:follow-button uid="2180128737" type="red_2" width="136" height="24" id="he-wb" ></wb:follow-button>
        <?php if ( $this->user->getIsGuest() === true ):?>
            <p class="he-lo">
              <a href="<?php echo $this->createUrl('/user/account/login')?>">登录</a>
              <a href="<?php echo $this->createUrl('/user/account/register')?>">注册中心</a>
              <a href="<?php echo $this->createUrl('/content/help')?>">帮助中心</a>
              <a href="#"><img src="<?php echo $this->imageUrl; ?>top-bg.png" />关注闪电贷微博</a>
            </p>
            <p class="he-wl">您好，欢迎你来到闪电贷！</p>
      <?php endif;?>
        </div>
      </div>
      <div id="he-nav">
        <div class="wd1002">
          <a href="<?php echo $this->createUrl('/')?>"><img src="<?php echo $this->imageUrl; ?>logo.png" id="logo" /></a>
        </div>
      </div>
    </div>
   <div id="container">
    <?php echo $content; ?>
    </div>
    <div id="footer">
      <div class="wd1002">
        <div id="copyright">
            <?php echo $this->app['copyright']?>
        </div>
      </div>
    </div>
</body>
</html>