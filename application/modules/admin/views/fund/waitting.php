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
		<th>来自</th>
		<th>去往</th>
		<th>资金</th>
		<th>手续费</th>
		<th>时间</th>
	</thead>
	
	<tbody>
	<?php foreach ( $dataProvider->getData() as $data ): ?>
		<tr>
			<td><?php echo $data->fromUser->nickname?></td>
			<td><?php echo $data->toUser->nickname?></td>
			<td><?php echo $data->sum / 100; ?></td>
			<td><?php echo $data->fee / 100; ?></td> 
			<td><?php echo date('Y-n-j H:i:s',$data->time); ?></td>
			<td><?php echo ''?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<div class="pagination">
	<?php $this->renderPartial('/public/pager',array('pager'=>$dataProvider->getPagination()))?>
</div>