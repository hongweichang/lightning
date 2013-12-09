<?php
/**
 * @name main.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-9-15
 * Encoding UTF-8
 */
$cssUrl = $this->request->baseUrl.'/css/';
$imgUrl = $this->request->baseUrl.'/images/';
$urlPrefix = $this->id.'/';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		
		<link href="<?php echo $cssUrl?>skin.css" rel="stylesheet" type="text/css" />
	</head>
	
	<body>
		<table width="100%" height="64" border="0" cellpadding="0" cellspacing="0" class="admin_topbg">
		  <tr>
		    <td width="61%" height="64" class="logo_text">
		    	<a href="<?php echo $this->createUrl('/site/welcome')?>" target="main">
		    	<img src="<?php echo $imgUrl?>logo.png" width="262" height="64" />
		    	</a>
		    </td>
		    <td width="39%" valign="top">
			    <table width="100%" border="0" cellspacing="0" cellpadding="0">
			      <tr>
			        <td width="74%" height="38" class="admin_txt"><?php echo $this->app->getUser()->getName();?><b></b> 您好,感谢登录使用！</td>
			        <td width="22%">
			        	<a href="<?php echo $this->createUrl('/site/logout')?>" target="_self" onClick="logout();">
			        	<img src="<?php echo $imgUrl?>out.gif" alt="安全退出" width="46" height="20" border="0">
			        	</a>
			        </td>
			        <td width="4%">&nbsp;</td>
			      </tr>
			      <tr>
			        <td height="19" colspan="3">&nbsp;</td>
			      </tr>
			    </table>
		    </td>
		  </tr>
		</table>
		
		<iframe src="<?php echo $this->createUrl('/site/menu')?>" width="14%" style="float:left;height:560px;border:0" scrolling="no" target="main" name="leftMenu">
		</iframe>
		<iframe src="<?php echo $this->createUrl('/site/welcome')?>" width="83%" style="height:700px;border:0" scrolling="auto" target="_self" name="main">
		</iframe>
	</body>
</html>