<?php
/**
 * @name loginRedirect.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-17 
 * Encoding UTF-8
 */
?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo $this->scriptUrl;?>jquery.min.js"></script>
		<link rel="stylesheet" href="<?php echo $this->cssUrl;?>reset.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $this->cssUrl;?>style.css" type="text/css" media="screen" />
	
		<style type="text/css">
		body {
	                font-family: Arial, Helvetica, sans-serif;
	                color: #555;
	                background: #f0f0f0 ;
	                font-size: 12px;
	                }
		</style>
	</head>
	
	<body>
		<div class="content-box" style="width:80%;margin:auto;margin-top:150px">
			<div class="content-box-header">
				<h3>提示信息</h3>
			</div>
			<div class="content-box-content">
				<h4>
					您还未登录，请登录后操作
				</h4>
				<h4>
					<a href="<?php echo $url;?>" target="_top">返 回 </a>
				</h4>
			</div>
		</div>
	</body>
</html>