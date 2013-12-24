<?php
	foreach($detailData as $key=>$value){
?>
	<h3>待审核项目<?php echo $key+1.;?></h3>
	<p>审核项名称：<?php echo $value['verification_name'];?></p>
	<p>联系电话: <?php echo $value['mobile'];?></p>
	<p>提交时间: <?php echo $value['submit_time']?></p>
	<p>附件图片</p>
<?php
	if($value['fileUrl'] !== null){ 
?>
	<img src="<?php echo $value['fileUrl']?>" style="width:400px;height:300px;"/>
<?php }?>
	<p><a href="<?php echo $this->createUrl('Download',array('id'=>$value['id']))?>">下载附件</a></p>
	<label>
	<a href="<?php echo $this->createUrl('creditVerify',array('id'=>$value['id'],'action'=>'pass'))?>">审核通过</a>
	<a href="<?php echo $this->createUrl('creditVerify',array('id'=>$value['id'],'action'=>'unpass'))?>">审核不通过</a>
	</label>
	<br/>
	<br/>

<?php } 
?>