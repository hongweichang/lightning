<?php 
$jsUrl = $this->scriptUrl;
$cssUrl = $this->cssUrl;
?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo CHtml::encode($this->getPageTitle())?></title>
	
	<link rel="stylesheet" href="<?php echo $cssUrl;?>reset.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo $cssUrl;?>style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo $cssUrl;?>invalid.css" type="text/css" media="screen" />
	<!--[if lte IE 7]>
	<link rel="stylesheet" href="<?php echo $cssUrl;?>ie.css" type="text/css" media="screen" />
	<![endif]-->

	<script type="text/javascript" src="<?php echo $jsUrl;?>jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $jsUrl;?>simpla.jquery.configuration.js"></script>
	<script type="text/javascript" src="<?php echo $jsUrl;?>facebox.js"></script>
	<script type="text/javascript" src="<?php echo $jsUrl;?>jquery.wysiwyg.js"></script>
	<!--[if IE 6]>
	<script type="text/javascript" src="<?php echo $jsUrl;?>DD_belatedPNG_0.0.7a.js"></script>
	<script type="text/javascript">
		DD_belatedPNG.fix('.png_bg, img, li');
	</script>
	<![endif]-->

</head>

<body id="login">
	<div id="login-wrapper" class="png_bg">
	<div id="login-top">
		<h1><?php echo $this->pageTitle?></h1>
		<img id="logo" src="<?php echo $this->imageUrl;?>logo.png" alt="sdd Admin logo" />
	</div>

	<div id="login-content">
		<?php $form = $this->beginWidget('CActiveForm',array(
		'id' => 'SddLoginForm',
		'method' => 'post',
		'focus' => array($model,'account'),
		))?>
	
	<p>
		<label><b>帐号</b></label>
		<?php echo $form->textField($model,'account',array('class'=>'text-input'))?>
	</p>
	<div class="clear"></div>
	<p>
		<label><b>密码</b></label>
		<?php echo $form->passwordField($model,'password',array('class'=>'text-input'))?>
	</p>
	<div class="clear"></div>
	<p>
		<?php echo CHtml::submitButton(' 登 录 ',array('class'=>'button'))?>
	</p>
	<div class="clear"></div>
	<div style="text-align:center;font-weight: 800;font-size: 18px">
		<?php echo $form->errorSummary($model,'无法登录')?>
	</div>
	
	<?php $this->endWidget()?>
		</div>
	</div>
</body>
</html>
