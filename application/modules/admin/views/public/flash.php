<?php 
$jsUrl = $this->scriptUrl;
$cssUrl = $this->cssUrl;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="refresh" content="<?php echo $waitSeconds;?>;url=<?php echo $jumpUrl;?>" /> 
	<link rel="stylesheet" href="<?php echo $cssUrl;?>reset.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo $cssUrl;?>style.css" type="text/css" media="screen" />
	
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
				<?php echo $message;?>
			</h4>
			<h4>
				<?php echo CHtml::link(' 返 回 ',$jumpUrl)?>
			</h4>
		</div>
	</div>
</body>
</html>