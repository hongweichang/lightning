<table class="userMessage">
    <tbody>
    <tr>
        <td><label>信用项标题</label></td>
        <td><label>信用项内容</label></td>
        <td><label>对应角色</label></td>
        <td><label>操作</label></td>
    </tr>
<?php
if(!empty($creditData)){
	foreach($creditData as $value){
?>
    <tr>
        <td><?php echo $value['title'];?></td>
        <td><?php echo $value['description'];?></td>
        <td>
            <?php
                if(!empty($value['roleData'])){
                    foreach($value['roleData'] as $roleValue){
                        echo FrontUser::getRoleName($roleValue->role)." ";
                    }
                }
            ?>
        </td>
        <td>
            <a href="<?php echo Yii::app()->createUrl('adminnogateway/credit/creditUpdate',array(
            'id'=>$value['id']))?>"  
            class="check" data-method="check-pass">编辑
            </a>
            <a href="<?php echo Yii::app()->createUrl('adminnogateway/credit/creditDelete',array(
            'id'=>$value['id']))?>" 
            class="check" data-method="check-pass">删除
            </a>
        </td>
    </tr>
 <?php }
 	}?>
    </tbody>
</table>