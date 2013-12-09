<?php
/**
 * @name menu.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-9-16
 * Encoding UTF-8
 */
$cssUrl = $this->request->baseUrl.'/css/';
$jsUrl = $this->request->baseUrl.'/js/';
$imgUrl = $this->request->baseUrl.'/images/';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理菜单</title>

<script src="<?php echo $jsUrl?>prototype.lite.js"
	type="text/javascript"></script>
<script src="<?php echo $jsUrl?>moo.fx.js" type="text/javascript"></script>
<script src="<?php echo $jsUrl?>moo.fx.pack.js" type="text/javascript"></script>
<link href="<?php echo $cssUrl?>menu.css" rel="stylesheet"
	type="text/css" />
</head>

<body>
	<table width="100%" height="280" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEF2FB">
		<tr>
			<td width="182" valign="top">
			<div id="container">
<?php if ( empty($this->menu) ):?>
				<h1 class="type">
					<a href="javascript:void(0)">暂无权限</a>
				</h1>
				<div class="content">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><img src="<?php echo $imgUrl;?>menu_topline.gif" width="182" height="5" /></td>
						</tr>
					</table>
					<ul class="submenu">
					</ul>
				</div>
<?php endif?>
<?php
	foreach ( $this->menu as $i => $menu ):
		$record = $menu['record'];
		if ( $menu['parent'] === null ):
?>
				<h1 class="type">
					<a href="javascript:void(0)"><?php echo $record->operation_name?></a>
				</h1>
				<div class="content">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><img src="<?php echo $imgUrl;?>menu_topline.gif" width="182" height="5" /></td>
						</tr>
					</table>
					<ul class="submenu">
<?php 	else:
			if ( $record->module === null )
				$url = '/'.$record->controller.'/'.$record->action;
			else 
				$url = '/'.$record->module.'/'.$record->controller.'/'.$record->action;
?>
						<li>
							<a href="<?php echo $this->createUrl($url)?>" target="main">
							<?php echo $record->operation_name?>
							</a>
						</li>
					
<?php 	endif;
	if ( isset($this->menu[$i+1]) )
		$next = $this->menu[$i+1];
	else 
		$next = false;
	if ( ($next===false) || ($menu['parent']!==null&&$next['parent']!==$menu['parent']) || ($next['parent']===null) ):
?>
						</ul>
					</div>
<?php endif;
endforeach;
?>
<script type="text/javascript">
		var contents = document.getElementsByClassName('content');
		var toggles = document.getElementsByClassName('type');
	
		var myAccordion = new fx.Accordion(
			toggles, contents, {opacity: true, duration: 400}
		);
		myAccordion.showThisHideOpen(contents[0]);
</script>
			</div>
			</td>
		</tr>
	</table>
</body>
</html>
