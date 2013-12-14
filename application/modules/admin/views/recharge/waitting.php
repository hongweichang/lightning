<?php
/**
 * file: waitting.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-12
 * desc: 
 */
$form=$this->beginWidget('CActiveForm',array(
	'focus' => array($selector,'nickname'),
	'method' => 'get'
));
?>
用户名：<?php echo $form->textField($selector,'nickname',array('class'=>'text-input tiny-input'));?>&nbsp;
姓名：<?php echo $form->textField($selector,'realname',array('class'=>'text-input tiny-input'));?>&nbsp;
电话：<?php echo $form->textField($selector,'mobile',array('class'=>'text-input tiny-input'));?>&nbsp;
银行卡：<?php echo $form->textField($selector,'bank',array('class'=>'text-input tiny-input'));?>&nbsp;
提现金额：<?php echo $form->textField($selector,'sum[]',array('class'=>'text-input tiny-input'));?>&nbsp;-&nbsp;
<?php echo $form->textField($selector,'sum[]',array('class'=>'text-input tiny-input'));?>&nbsp;
<?php echo CHtml::submitButton(' 搜 索 ',array('class'=>'button'))?>
<?php $this->endWidget()?>

<table>
	<thead>
		<th>用户名</th>
		<th>姓名</th>
		<th>性别</th>
		<th>电话</th>
		<th>银行卡</th>
		<th>提现金额</th>
		<th>手续费</th>
		<th>发起时间</th>
		<th>操作</th>
	</thead>
	
	<tbody>
	<?php foreach ( $dataProvider->getData() as $data ):
		$gender = $data->user->gender;
		if ( empty($gender) )
			$g = '';
		elseif ( $gender == 1 ) 
			$g = '男';
		else 
			$g = '女';
	?>
		<tr>
			<td><?php echo $data->user->nickname?></td>
			<td><?php echo $g?></td>
			<td><?php echo $data->user->realname?></td>
			<td><?php echo $data->user->mobile?></td>
			<td><?php echo $data->user->bank?></td>
			<td><?php echo $data->sum / 100; ?></td>
			<td><?php echo $data->fee / 100; ?></td> 
			<td><?php echo date('Y-n-j H:i:s',$data->raise_time); ?></td>
			<td><?php echo ''?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<div class="pagination">
	<?php $this->renderPartial('/public/pager',array('pager'=>$dataProvider->getPagination()))?>
</div>