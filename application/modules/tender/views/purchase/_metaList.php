<?php
/**
 * file: _metaList.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-9
 * desc: 
 */
?>
<tr>
	<td><?php echo $data['user_id'];?></td>
	<td><?php echo number_format($data['sum'] / 100,2);?></td>
	<td><?php echo number_format($data['refund'] / 100,2);?></td>
	<td><?php echo $data['finish_time'] ? date('Y-n-j H:i:s',$data['finish_time']) : '等待付款';?></td>
	<!-- <td>什么意思？？</td>-->
</tr>