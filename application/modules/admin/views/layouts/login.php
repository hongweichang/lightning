<?php
/**
 * file: login.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-28
 * desc: 
 */
$this->cs->registerCssFile($this->cssUrl.'common.css');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>闪电贷</title>
</head>
<body>
<div id="header">
    <div id="he-login">
        <div class="wd1002">
        </div>
        <div id="he-nav">
            <div class="wd1002">
                <img src="<?php echo $this->imageUrl; ?>logo.png" id="logo" />
            </div>
        </div>
    </div>
</div>
<div id="login"><?php echo $content; ?></div>
<div id="footer">
        <p>重庆闪电贷金融信息服务有限公司 版权所有 2007-2013<p>
        <p>Copyright Reserved 2007-2013©闪电贷（www.sddai.com） | 渝ICP备05063398号</p>
</div>
</body>
</html>