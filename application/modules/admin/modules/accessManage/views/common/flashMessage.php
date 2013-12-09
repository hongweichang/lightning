<?php
/**
 * @name flashMessage.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-4
 * Encoding UTF-8
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="refresh" content="<?php echo $waitSeconds;?>;url=<?php echo $jumpUrl;?>" /> 
		<script type="text/javascript">
		</script>
	<title>消息提示</title>
</head>
<body>
	<div style="text-align: center; border: #B5ECE8 2px dashed; width: 30%; height: 150px; margin: 100px auto;">
		<table width="100%" cellpadding="3" cellspacing="0" align="center">
			<tr bgcolor="#cceeff">
				<td style="text-align: center">消息提示</td>
			</tr>
			<tr>
				<td>
					<p style="padding-top: 10px;">
						<div style="text-align: center">
						<?php echo $msg;?>
						</div>
						<div style="text-align: center">
							页面将在
							<?php echo $waitSeconds;?>
							后进行跳转
						</div>
						<div style="text-align: center">
							如果您的浏览器没有反应，请点击<a href="<?php echo $jumpUrl;?>">这里</a>
						</div>
					</p>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
