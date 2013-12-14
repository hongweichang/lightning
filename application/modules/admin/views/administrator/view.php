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
帐号：<?php echo $form->textField($selector,'account',array('class'=>'text-input tiny-input'));?>&nbsp;
<?php echo CHtml::submitButton(' 搜 索 ',array('class'=>'button'))?>
<?php $this->endWidget()?>

<table>
	<thead>
		<th>昵称</th>
		<th>帐号</th>
		<th>角色</th>
		<th>操作</th>
	</thead>
	
	<tbody>
	<?php foreach ( $dataProvider->getData() as $data ):
		$roles = $data->baseUser->authRoles;
	?>
		<tr>
			<td><?php echo $data->nickname?></td>
			<td><?php echo $data->account?></td>
			<td>
				<?php foreach ( $roles as $role ):
					echo $role->role_name.'<br />';
				endforeach;?>
			</td>
			<td>
			<?php $params = array('id'=>$data->id,'redirect'=>$pageUrl);?>
			<a class="deleteLink" href="<?php echo $this->createUrl('administrator/delete',$params)?>">删除</a>
			&nbsp;|
			<a href="<?php echo $this->createUrl('administrator/lock',$params)?>"><?php echo $data->locked == 1 ? '解除锁定' : '锁定'?></a>
			&nbsp;|
			<a href="<?php echo $this->createUrl('administrator/edit',$params)?>">修改</a>
			&nbsp;|
			<a href="<?php echo $this->createUrl('administrator/logs',$params)?>">操作日志</a>
			</td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<div class="pagination">
	<?php $this->renderPartial('/public/pager',array('pager'=>$pager))?>
</div>