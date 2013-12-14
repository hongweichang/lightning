<?php
/**
 * file: waitting.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-12
 * desc: 
 */
$status = array('待审核','正在招标','正在还款','已完成','已流标');
$form=$this->beginWidget('CActiveForm',array(
	'focus' => array($selector,'nickname'),
	'method' => 'get'
));
?>
用户名：<?php echo $form->textField($selector,'nickname',array('class'=>'text-input tiny-input'));?>&nbsp;
标题：<?php echo $form->textField($selector,'title',array('class'=>'text-input tiny-input'));?>&nbsp;
金额：<?php echo $form->textField($selector,'sum',array('class'=>'text-input tiny-input'));?>&nbsp;
年利率：<?php echo $form->textField($selector,'month_rate',array('class'=>'text-input tiny-input'));?>&nbsp;
期限：<?php echo $form->textField($selector,'deadline',array('class'=>'text-input tiny-input'));?>&nbsp;
进度：<?php echo $form->textField($selector,'progress',array('class'=>'text-input tiny-input'));?>&nbsp;
<?php echo CHtml::submitButton(' 搜 索 ',array('class'=>'button'))?>
<?php $this->endWidget()?>

<table>
	<thead>
		<th>用户名</th>
		<th>标题</th>
		<th>金额</th>
		<th>年利率</th>
		<th>期限</th>
		<th>开始时间</th>
		<th>结束时间</th>
		<th>招标进度</th>
		<th>发布时间</th>
		<th>状态</th>
	</thead>
	
	<tbody>
	<?php foreach ( $dataProvider->getData() as $data ): ?>
		<tr>
			<td><?php echo $data->user->nickname; ?></td>
			<td><?php echo $data->title; ?></td>
			<td><?php echo $data->sum / 100; ?></td>
			<td><?php echo $data->month_rate / 100; ?></td> 
			<td><?php echo $data->deadline; ?></td>
			<td><?php echo date('Y-n-j H:i:s',$data->start); ?></td>
			<td><?php echo date('Y-n-j H:i:s',$data->end); ?></td>
			<td><?php echo $data->progress; ?></td>
			<td><?php echo date('Y-n-j H:i:s',$data->pub_time); ?></td>
			<td><?php echo $status[$data->verify_progress];?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<div class="pagination">
	<?php $this->renderPartial('/public/pager',array('pager'=>$dataProvider->getPagination()))?>
</div>