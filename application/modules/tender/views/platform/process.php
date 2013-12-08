<?php
/**
 * file: processing.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-3
 * desc: 
 */
$this->cs->registerScript('submit',"
$(document).ready(function(){
	setTimeout(function(){
		document.forms['submit'].submit();
	},1000);
});	
");
?>
美工死哪里去了？没图将就一下吧~<br />
订单提交中...
<form id="submit" method="post" action="<?php echo $action?>">
<input type="hidden" name="sum" value="<?php echo $sum; ?>" />
</form>