<table class="userMessage">
    <tbody>
    <tr>
        <td><label>会员级别</label></td>
        <td><label>会员分数</label></td>
        <td><label>充值利率</label></td>
        <td><label>提现利率</label></td>
        <td><label>还款利率</label></td>
        <td><label>借款大于6个月利率</label></td>
        <td><label>借款低于6个月利率</label></td>
        <td><label>标段利息利润利率</label></td>
        <td><label>该等级是否能借款</label></td>
        <td><label>操作</label></td>
    </tr>
<?php
if(!empty($LevelData)){
	foreach($LevelData as $value){
?>
    <tr>
        <td><?php echo $value['label'];?></td>
        <td><?php echo $value['start'];?></td>
        <td><?php echo $value['on_recharge'].'%';?></td>
        <td><?php echo $value['on_withdraw'].'%';?></td>
        <td><?php echo $value['on_pay_back'].'%'?></td>
        <td><?php echo $value['on_over6'].'%'?></td>
        <td><?php echo $value['on_below6'].'%'?></td>
        <td><?php echo $value['on_loan'].'%'?></td>
        <td>
        <?php
            if($value['loanable'] == 0)
                echo "不能";
            else
                echo "可以";
        ?>
        </td>
        <td>
            <a href="<?php echo Yii::app()->createUrl('adminnogateway/credit/creditLevelUpdate',array(
            'id'=>$value['id']))?>"  
            class="check" data-method="check-pass">编辑
            </a>
            <a href="<?php echo Yii::app()->createUrl('adminnogateway/credit/creditLevelDelete',array(
            'id'=>$value['id']))?>" 
            class="check" data-method="check-pass">删除
            </a>
        </td>
    </tr>
 <?php }
 	}?>
    </tbody>
</table>