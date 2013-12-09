<?php
/**
 * file: _metaList.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-9
 * desc: 
 */

?>
<tr>
	<td><?php echo $data->getRelated('user')->getAttribute('nickname');?></td>
	<td><?php echo number_format($data->getAttribute('sum') / 100,2);?></td>
	<td><?php echo number_format($data->getAttribute('refund') / 100,2);?></td>
	<td><?php echo $data->getAttribute('finish_time') ? date('Y-n-j H:i:s',$data->getAttribute('finish_time')) : '等待付款';?></td>
	<!-- <td>什么意思？？</td>-->
</tr>