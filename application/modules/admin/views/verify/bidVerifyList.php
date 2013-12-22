<table>
    <tbody>
    <tr>
        <td>标段标题</td>
        <td>标段简介</td>
        <td>借款总额</td>
        <td>借款期限</td>
        <td>年利率</td>
        <td>用户昵称</td>
        <td>用户真实姓名</td>
        <td>用户手机号码</td>
        <td>用户信用级别</td>
        <td>操作</td>
    </tr>
<?php
if(!empty($bidList)){
	foreach($bidList as $value){
?>
    <tr>
        <td><?php echo $value['title'];?></td>
        <td><?php echo $value['description'];?></td>
        <td><?php echo $value['sum'].'元'?></td>
        <td><?php echo $value['deadline'].'个月'?></td>
        <td><?php echo $value['rate'].'%';?></td>
        <td><?php echo $value['nickname'];?></td>
        <td><?php echo $value['realname'];?></td>
        <td><?php echo $value['mobile'];?></td>
        <td><?php echo $value['level'];?></td>
        <td>
            <a href="<?php echo Yii::app()->createUrl('adminnogateway/verify/bidVerify',array(
            'action'=>'pass','id'=>$value['id']))?>"  
            class="check" data-method="check-pass">审核通过
            </a>
            <a href="<?php echo Yii::app()->createUrl('adminnogateway/verify/bidVerify',array(
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
