<?php $this->renderPartial('_baseUserInfo',array('data'=>$userData[0]))?>

<h3>用户信用资料</h3>
<table>
	<tbody>
		<?php foreach($userCredit as $value){?>
		<tr>
			<td><?php echo $value['verification_name'];?><td>
			<?php
				if(!empty($value['fileUrl'])){
			 ?>
			 <td><img src="<?php echo $value['fileUrl']?>" style="width:400px;height:300px";/></td>
			 <td><a href="<?php echo $this->createUrl('Download',array('id'=>$value['id']))?>">下载图片</a></td>	
			<?php }else{
			?>
			<td clospan="2">
				<a href="<?php echo $this->createUrl('Download',array('id'=>$value['id']))?>">下载附件</a>
			</td>
			<?php }?>
			<?php if ( $id != null ):?>
			<td>
			<a href="<?php echo $this->createUrl('creditVerify',array('id'=>$value['id'],'action'=>'unpass','uid'=>$userData[0]->id))?>">审核不通过</a>
			</td>
			<?php endif;?>
		</tr>
		<?php }?>
	</tbody>
</table>

<?php if ( empty($id) === false && true === is_numeric($id) ):?>
<h3>该标段是否通过审核？</h3>
<label>
<a href="<?php echo Yii::app()->createUrl('adminnogateway/verify/bidVerify',array(
            'action'=>'pass','id'=>$id))?>"  
   class="check" data-method="check-pass">审核通过
</a>
</label>
<label>
<a href="<?php echo Yii::app()->createUrl('adminnogateway/verify/bidVerify',array(
            'action'=>'unpass','id'=>$id))?>" 
   class="check" data-method="check-pass">审核不通过
</a>
</label>
<?php endif;?>