<?php 
$jsUrl = $this->scriptUrl;
$cssUrl = $this->cssUrl;
?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href=<?php echo $cssUrl?>reset.css>
	<link rel="stylesheet" type="text/css" href=<?php echo $cssUrl?>style.css>
	<script type="text/javascript" src="<?php echo $jsUrl;?>jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $jsUrl;?>simpla.jquery.configuration.js"></script>
	<script type="text/javascript" src="<?php echo $jsUrl;?>jquery.wysiwyg.js"></script>
	
	<!--[if IE]>
	<script type="text/javascript" src="<?php echo $jsUrl;?>jquery.bgiframe.js"></script>
	<![endif]-->

	<!--[if IE 6]>
	<script type="text/javascript" src="<?php echo $jsUrl;?>DD_belatedPNG_0.0.7a.js"></script>
	<script type="text/javascript">
		DD_belatedPNG.fix('.png_bg, img, li');
	</script>
	<![endif]-->
	<style type="text/css">
body {
                font-family: Arial, Helvetica, sans-serif;
                color: #555;
                background: #f0f0f0 ;
                font-size: 12px;
                }
	</style>
</head>



<body >
	<div id="main-content">
		<h2>你好，<?php echo $this->user->getName()?></h2>
		<p id="page-intro">欢迎进入闪电贷后台管理系统</p>
		
		<div class="clear"></div>
		<div class="content-box">
			<div class="content-box-header">
				<ul class="content-box-tabs">
					<?php foreach ( $this->subTabs as $subTab ):
						echo $subTab;
					endforeach;?>
				</ul>
				<div class="clear"></div>
			</div>
			<div class="content-box-content">
				<?php echo $content;?>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	
	<div id="footer">
	<?php echo $this->app['copyright']?>
	</small>
</div>
</body>

</html>