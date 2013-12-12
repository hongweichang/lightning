<?php
/**
 * file: waitting.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-12
 * desc: 
 */
?>
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
	<?php foreach ( $data->getData() as $data ):
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
	<?php $this->renderPartial('/public/pager',array('pager'=>$pager))?>
</div>