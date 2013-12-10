<table class="userMessage">
    <tbody>
    <tr>
        <td>信用项标题</td>
        <td>信用项内容</td>
        <td>操作</td>
    </tr>
<?php
if(!empty($creditData)){
	foreach($creditData as $value){
?>
    <tr>
        <td><?php echo $value['verification_name'];?></td>
        <td><?php echo $value['description'];?></td>
        <td>
            <a href="<?php echo Yii::app()->createUrl('adminnogateway/verify/creditVerify',array(
            'action'=>'pass','id'=>$value['id']))?>"  
            class="check" data-method="check-pass">审核通过
            </a>
            <a href="<?php echo Yii::app()->createUrl('adminnogateway/verify/creditVerify',array(
            'action'=>'unpass','id'=>$value['id']))?>" 
            class="check" data-method="check-pass">审核不通过
            </a>
            <a href="<?php echo Yii::app()->createUrl('user/userInfo/outputInfoByExcel');?>">导出</a>
        </td>
    </tr>
 <?php }
 	}?>
    </tbody>
</table>