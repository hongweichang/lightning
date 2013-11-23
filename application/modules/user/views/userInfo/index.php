<?php
	echo $userInfo[0]->verification_id;
	echo $userInfo[0]->id;
?>
<a href="<?php echo Yii::app()->createUrl('user/userInfo/download',array('id'=>$userInfo[0]->id));?>">下载附件</a>
<a href="<?php echo Yii::app()->createUrl('user/userInfo/verify',array('id'=>$userInfo[0]->id,'action'=>'pass'));?>">审核通过</a>
<a href="<?php echo Yii::app()->createUrl('user/userInfo/verify',array('id'=>$userInfo[0]->id,'action'=>'unpass'));?>">审核不通过</a>
