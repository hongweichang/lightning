<table class="userMessage">
	<tbody>
    <tr>
        <td><label>债权标题</label></td>
        <td><label>开始时间</label></td>
        <td><label>结束时间</label></td>
        <td><label>期限</label></td>
        <td><label>操作</label></td>
    </tr>
    <?php foreach($debtList as $value){?>
    <tr>
    	<td><?php echo $value['title'];?></td>
        <td><?php echo $value['start'];?></td>
        <td><?php echo $value['end'];?></td>
        <td><?php echo $value['deadline'];?></td>
        <td>
        	<a href="<?php echo Yii::app()->createUrl('adminnogateway/debt/debtUpdate',array(
            'id'=>$value['id']))?>"  
            class="check" data-method="check-pass">编辑</a>
        	<a href="<?php echo Yii::app()->createUrl('adminnogateway/debt/debtdelete',array(
            'id'=>$value['id']))?>" 
            class="check" data-method="check-pass">删除</a>
        </td>
    </tr>
    <?php }?>
	</tbody>
</table>