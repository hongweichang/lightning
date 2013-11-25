<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>闪电贷</title>
    <script type="text/javascript" src="<?php echo $this->scriptUrl; ?>jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->scriptUrl; ?>jquery.validate.min.js"></script>
</head>
<body>
	<div class="wrapper">
		<div id="header">
	        <div id="he-login"></div>
	        <div id="he-nav">
	            <div class="wd1002">
	                <img src="<?php echo $this->imageUrl; ?>logo.png" id="logo" />
	            </div>
	        </div>
	    </div>
		<div id="container"><?php echo $content; ?></div>
		<div class="push"></div>
	</div>
	<div id="footer">
        <div class="wd1002">         
            <div id="copyright">
                <p>重庆闪电贷金融信息服务有限公司 版权所有 2007-2013<p>
                <p>Copyright Reserved 2007-2013©闪电贷（www.sddai.com） | 渝ICP备05063398号</p>
            </div>
        </div>
    </div>
</body>
</html>