<?php 
$this->cs->registerCssFile($this->cssUrl.'alert.css');
if(Yii::app()->user->hasFlash('error')){
?>
<script>alert('附件不存在！');</script>
<?php
}
?>
<table class="userMessage">
    <tbody>
    <tr>
        <td>姓名</td>
        <td>操作</td>
    </tr>
<?php
if(!empty($userCreditData)){
	foreach($userCreditData as $key=>$value){
?>
    <tr>
        <td><?php echo $key;?></td>
        <td>
            <a href="<?php echo Yii::app()->createUrl('adminnogateway/verify/creditDetail',array('id'=>$value[0]['user_id']))?>" class = "verify">审核</a>
        </td>
    </tr>
 <?php }
 	}?>
    </tbody>
</table>
<div class="pagination">
	<?php $this->renderPartial('/public/pager',array('pager'=>$pages))?>
</div>


