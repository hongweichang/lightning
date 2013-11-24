<?php
if(!empty($userInfo)){
	foreach($userInfo as $value){
		var_dump($value['attributes']);

?>
<a href="<?php echo Yii::app()->createUrl('user/userInfo/download',array('id'=>$value->id));?>">下载附件</a>
<a href="<?php echo Yii::app()->createUrl('user/userInfo/verify',array('id'=>$value->id,'action'=>'pass'));?>">审核通过</a>
<a href="<?php echo Yii::app()->createUrl('user/userInfo/verify',array('id'=>$value->id,'action'=>'unpass'));?>">审核不通过</a>
<a href="<?php echo Yii::app()->createUrl('user/userInfo/outputInfoByExcel');?>">导出</a>
<br/>
<?php }
		}
?>