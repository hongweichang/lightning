<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title><?php echo CHtml::encode($this->getPageTitle())?></title>
</head>
<body>
    <div id="header">
        <div id="he-login">
            <div class="wd1002">
                <p class="he-lo">
                    <span>你好欢迎登陆，[<a href="#">注销</a>]</span>
                    <a href="<?php echo $this->createUrl('/site')?>" class="he-where" target="_blank">前台首页</a>
                </p>
            </div>
        </div>
        <div id="he-nav">
            <div class="wd1002">
                <img src="<?php echo $this->imageUrl?>logo.png" id="logo" />
                <ul id="main-nav">
                    <li><a href="userManage.html">用户和管理员</a></li>
                    <li><a href="tenders.html">标段信息</a></li>
                    <li><a href="informationCheck.html">信息审核</a></li>
                    <li><a href="secrity.html">安全卫士</a></li>
                    <li><a href="pay.html">充值提现</a></li>
                    <li><a href="notify.html">通知消息</a></li>
                    <li><a href="fund.html">资金统计</a></li>
                    <li><a href="content.html">内容管理</a></li>
                </ul>
            </div>
        </div>
    </div>
    <?php echo $content;?>
    <div id="backStage">
    	<div class="wd1002">
            <div class="back-left">
		                <h1>
		                    <img src="<?php echo $this->imageUrl?>menu-log.png" />
		                    <span>管理菜单</span>
		                </h1>
		                <ul id="left-back">
		                    <li id="userManageInformationList">用户信息列表</li>
		                    <li><span></span>信用信息审核
		                        <ul class="list-2">
		                            <li id="userManageMustWrite">必填信息</li>
		                            <li id="userManageChooseWrite">选填信息</li>
		                        </ul>
		                    </li>
		                    <li id="userManageMemberconfiguration">会员级别配置</li>
		                    <li id="userManageList"><span></span>管理员列表</li>
		                </ul>
		</div>
		<div class="back-right">
            </div>
        	<div id="copyright">
                <p>重庆闪电贷金融信息服务有限公司 版权所有 2007-2013
                Copyright Reserved 2007-2013©闪电贷（www.sddai.com） | 渝ICP备05063398号</p>
            </div>
	</div>
    </div>
</body>
</html>