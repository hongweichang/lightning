<?php
/**
 * file: main.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-28
 * desc: 
 */
$this->cs->registerScriptFile($this->scriptUrl.'jquery-1.8.2.min.js',CClientScript::POS_END);
$this->cs->registerScriptFile($this->scriptUrl.'ajaxMVC.js',CClientScript::POS_END);
$this->cs->registerCssFile($this->cssUrl.'common.css');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>闪电贷</title>
</head>
<body>
    <div id="header">
        <div id="he-login">
            <div class="wd1002">
                <p class="he-lo">
                    <span>你好欢迎登陆，[<a href="<?php echo $this->createUrl('index/logout'); ?>">注销</a>]</span>
                    <a href="<?php echo Yii::app()->homeUrl; ?>" class="he-where">前台首页</a>
                    <a href="#">缓存更新</a>
                </p>
            </div>
        </div>
        <div id="he-nav">
            <div class="wd1002">
                <img src="<?php echo $this->imageUrl; ?>logo.png" id="logo" />
                <ul id="main-nav">
                    <li><a href="userManage.html">用户和管理员</a></li>
                    <li><a href="tenders.html">标段信息</a></li>
                    <li><a href="informationCheck.html">信息审核</a></li>
                    <li><a href="secrity.html">安全卫士</a></li>
                    <li><a href="#" class="now-page">充值提现</a></li>
                    <li><a href="notify.html">通知消息</a></li>
                    <li><a href="fund.html">资金统计</a></li>
                    <li><a href="content.html">内容管理</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div id="backStage">
    	<div class="wd1002">
			<div class="back-left">
				<h1>
					<img src="<?php echo $this->imageUrl; ?>menu-log.png" />
					<span>管理菜单</span>
				</h1>
				<ul id="left-back"><?php echo $content; ?></ul>
			</div>
			<div class="back-right"></div>
            <div id="copyright">
                <p>重庆闪电贷金融信息服务有限公司 版权所有 2007-2013
                    Copyright Reserved 2007-2013©闪电贷（www.sddai.com） | 渝ICP备05063398号</p>
            </div>
        </div>
    </div>
</body>
</html>