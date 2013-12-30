<?php
/**
 * @name view.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-10 
 * Encoding UTF-8
 */
$form=$this->beginWidget('CActiveForm',array(
		'focus' => array($selector,'nickname'),
		'method' => 'get'
));
$pager = $dataProvider->getPagination();
$pageUrl = urlencode( $pager->createPageUrl($this,$pager->getCurrentPage()) );
?>
昵称：<?php echo $form->textField($selector,'nickname',array('class'=>'text-input tiny-input'));?>&nbsp;
姓名：<?php echo $form->textField($selector,'realname',array('class'=>'text-input tiny-input'));?>&nbsp;
手机号码：<?php echo $form->textField($selector,'mobile',array('class'=>'text-input tiny-input'));?>&nbsp;
邮箱：<?php echo $form->textField($selector,'email',array('class'=>'text-input tiny-input'));?>&nbsp;
余额：<?php echo $form->textField($selector,'balance[]',array('class'=>'text-input tiny-input'));?>&nbsp;-&nbsp;
<?php echo $form->textField($selector,'balance[]',array('class'=>'text-input tiny-input'));?>&nbsp;
<?php echo CHtml::submitButton(' 搜 索 ',array('class'=>'button'))?>
<?php $this->endWidget()?>

<table>
	<thead>
		<th>昵称</th>
		<th>性别</th>
		<th>姓名</th>
		<th>手机</th>
		<th>邮箱</th>
		<th>身份证</th>
		<th>余额</th>
		<th>操作</th>
	</thead>
	
	<tbody>
	<?php foreach ( $dataProvider->getData() as $data ):
		$gender = $data->gender;
		if ( empty($gender) )
			$g = '';
		elseif ( $gender == 1 ) 
			$g = '男';
		else 
			$g = '女';
	?>
		<tr>
			<td><?php echo $data->nickname?></td>
			<td><?php echo $g?></td>
			<td><?php echo $data->realname?></td>
			<td><?php echo $data->mobile?></td>
			<td><?php echo $data->email?></td>
			<td><?php echo $data->identity_id?></td>
			<td><?php echo $data->balance?></td>
			<td>
				<a class="openWindow" href="<?php echo $this->createUrl('verify/userDetail',array('uid'=>$data->id))?>">查看信用信息</a> | 
				<a href="<?php echo $this->createUrl('frontUser/edit',array('id'=>$data->id,'redirect'=>$pageUrl))?>">修改</a>
			</td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<div class="pagination">
	<?php $this->renderPartial('/public/pager',array('pager'=>$dataProvider->getPagination()))?>
	</div>