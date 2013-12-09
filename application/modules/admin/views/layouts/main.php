<?php 
$jsUrl = Yii::app()->controller->module->jsUrl;
$cssUrl = Yii::app()->controller->module->cssUrl;
?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
	<?php echo $content;?>
	</div>
</body>

</html>