<?php
	$this->renderPartial('_baseUserInfo',array('data'=>$user));
	foreach($detailData as $key=>$value):
?>
	<h3>待审核项目：<?php echo $value['verification_name'];?></h3>
	<p>提交时间: <?php echo $value['submit_time']?></p>
	<p>附件图片</p>
<?php
	if($value['fileUrl'] !== null):
?>
	<img src="<?php echo $value['fileUrl']?>" style="width:400px;height:300px;"/>
<?php endif;?>
	<p><a href="<?php echo $this->createUrl('Download',array('id'=>$value['id']))?>">下载附件</a></p>
	<label>
	<a href="<?php echo $this->createUrl('creditVerify',array('id'=>$value['id'],'action'=>'pass','uid'=>$user->id))?>">通过</a>
	<a href="<?php echo $this->createUrl('creditVerify',array('id'=>$value['id'],'action'=>'unpass','uid'=>$user->id))?>">不通过</a>
	</label>
	<br/>
	<br/>

<?php endforeach;?>