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
	<td>系统</td>
	<td><?php echo number_format($data->getAttribute('sum') / 100,2); ?>元</td>
	<td><?php echo number_format($data->getAttribute('fee') / 100,2); ?>元</td>
	<td><?php $status = $data->getAttribute('status');
		if($status == 0) echo "等待充值";
		elseif($status == 1) echo "充值成功";
		elseif($status == 2) echo "充值完成";
		else echo "充值取消";
	?></td>
	<td><?php if($status == 0){ ?>
	<a href="<?php echo $this->app->createUrl('pay/'.$data->getAttribute('platform').'/order',array(
		'key' => Utils::appendEncrypt($data->getAttribute('id'))
	)); ?>">去充值</a>
	<?php } ?></td>
</tr>