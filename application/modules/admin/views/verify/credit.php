<?php if(Yii::app()->user->hasFlash('error')){
?>
<script>alert('附件不存在！');</script>
<?php
}
?>
<table class="userMessage">
    <tbody>
    <tr>
        <td>昵称</td>
        <td>姓名</td>
        <td>手机号码</td>
        <td>审核内容</td>
        <td>附件</td>
        <td>上传时间</td>
        <td>操作</td>
    </tr>
<?php
if(!empty($userCreditData)){
	foreach($userCreditData as $value){
?>
    <tr>
        <td><?php echo $value['nickname'];?></td>
        <td><?php echo $value['realname'];?></td>
        <td><?php echo $value['mobile'];?></td>
        <td><?php echo $value['verification_name'];?></td>
        <td>
        	<a href="<?php echo Yii::app()->createUrl('adminnogateway/verify/download',array('id'=>$value['id']));?>">下载附件</a>
        	<?php if(!empty($value['fileUrl'])){?>
        	<a href="<?php echo Yii::app()->createUrl($value['fileUrl']);?>">查看</a>
        	<?php }?>
        </td>
        <td><?php echo $value['submit_time'];?></td>
        <td>
            <a href="<?php echo Yii::app()->createUrl('adminnogateway/verify/creditVerify',array(
            'action'=>'pass','id'=>$value['id']))?>"  
            class="check" data-method="check-pass">审核通过
            </a>
            <a href="<?php echo Yii::app()->createUrl('adminnogateway/verify/creditVerify',array(
            'action'=>'unpass','id'=>$value['id']))?>" 
            class="check" data-method="check-pass">审核不通过
            </a>
        </td>
    </tr>
 <?php }
 	}?>
    </tbody>
</table>
<div class="pagination">
	<?php $this->renderPartial('/public/pager',array('pager'=>$pages))?>
</div>

