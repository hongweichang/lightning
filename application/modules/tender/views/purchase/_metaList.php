<?php
/**
 * file: _metaList.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-9
 * desc: 
 */
$status = array(
	'11' => '未付款',
	'20' => '已取消',
	'21' => '已付款',
	'30' => '已关闭',
	'31' => '收款中',
	'40' => '逾期',
	'41' => '已完成'
);
?>
<tr>
	<td><?php echo $data->getRelated('user')->getAttribute('nickname');?></td>
	<td><?php echo number_format($data->getAttribute('sum') / 100,2);?></td>
	<td><?php echo number_format($data->getAttribute('refund') / 100,2);?></td>
	<td><?php if($data->getAttribute('pay_time')) echo date('Y-n-j H:i:s',$data->getAttribute('pay_time'));?></td>
	<td><?php echo $status[$data->getAttribute('status')]; ?></td>
</tr>