<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />
		<title>BT后台管理系统</title>
	</head>
	
	<frameset cols="245,*"  frameborder="NO" border="0" framespacing="0">
		<frame src="<?php echo $this->createUrl('index/menu');?>" name="leftFrame" noresize="noresize" marginwidth="0" marginheight="0" frameborder="0" scrolling="no" target="mainFrame" />
		<frame src="<?php echo $this->createUrl('index/welcome');?>" name="mainFrame" marginwidth="0" marginheight="0" frameborder="0" scrolling="auto" target="_self" />
	</frameset>
	
	<noframes>
	<body>
	</body>
	</noframes>

</html>