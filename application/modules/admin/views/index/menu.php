<?php 
$jsUrl = $this->scriptUrl;
$cssUrl = $this->cssUrl;
?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<title>管理菜单</title>
	<link rel="stylesheet" href="<?php echo $cssUrl;?>style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo $cssUrl;?>perfect-scrollbar.css" type="text/css" media="screen" />
	
	<!--[if lte IE 7]>
	<link rel="stylesheet" href="<?php echo $cssUrl;?>ie.css" type="text/css" media="screen" />
	<![endif]-->
	
	<script type="text/javascript" src="<?php echo $jsUrl;?>jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $jsUrl;?>perfect-scrollbar.js"></script>
	<script type="text/javascript" src="<?php echo $jsUrl;?>jquery.mousewheel.js"></script>
	<script type="text/javascript" src="<?php echo $jsUrl;?>simpla.jquery.configuration.js"></script>
	
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
		.contentHolder { position:relative; margin:0px auto; padding:0px; height:768px;overflow: hidden; }
        .contentHolder .content {height:800px}
        .spacer { text-align:center }
	</style>
</head>

<body id="Default" class="contentHolder">
	<div class="content">
		<div id="sidebar">
	<div id="sidebar-wrapper">

		<h1 id="sidebar-title">
			<a href="#"><?php echo $this->getPageTitle()?></a>
		</h1>

		<a href="<?php echo Yii::app()->createUrl('admin/index/index');?>" target="_blank">
		<img id="logo" src="<?php echo $imgUrl;?>logo.png" alt="<?php echo $this->getPageTitle()?>" />
		</a>

		<div id="profile-links">
			你好，管理员 
			<a href="#" title="编辑个人信息" target="mainFrame">
			<?php echo Yii::app()->user->getState('userName');?>
			</a>
			<br />
			<a href="<?php echo $this->app->getSiteBaseUrl()?>" target="_blank" title="浏览网站前台">浏览网站</a> | 
			<a href="<?php echo $this->createUrl('account/logout')?>" target="_parent" title="退出登录">登出</a>
		</div>

		<ul id="main-nav">
			<?php
				foreach ( $this->menu as $i => $menu ):
					$record = $menu['record'];
					if ( $menu['parent'] === null ):
			?>
			<li>
			<a href="<?php echo Yii::app()->createUrl($url)?>" class="nav-top-item">
					<?php echo $m['parent']->getName();?>
			</a>
				<?php if ($m['children'] ){
					echo '<ul>';
					foreach( $m['children'] as $child){
					$url = 'admin/'.$child->getController().'/'.$child->getAction()
				?>
					<li>
						<a href="<?php echo Yii::app()->createUrl($url)?>" target="mainFrame">
						<?php echo $child->getName();?>
						</a>
					</li>
				<?php }
					echo '</ul>';
				}?>
			</li>
			<?php endforeach;?>
		</ul>

	</div>
</div>
	</div>

</body>

</html>