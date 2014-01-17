<?php
/**
 * file: _p2pList.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-20
 * desc: 
 */
?>
<tr>
	<td><?php echo date('Y-n-j H:i:s',$data->getAttribute('raise_time')); ?></td>
	<td><?php echo $data->getRelated('user')->getAttribute('bank'); ?></td>
	<td>-<?php echo number_format($data->getAttribute('sum') / 100,2); ?>元</td>
	<td><?php echo number_format($data->getAttribute('fee') / 100,2); ?>元</td>
	<td><?php $status = $data->getAttribute('status');
		if($status == 0) echo "正在处理";
		elseif($status == 1) echo "提现完成";
		else echo "提现失败";
	?></td>
	<td></td>
</tr>