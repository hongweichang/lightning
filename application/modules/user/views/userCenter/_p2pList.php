<?php
/**
 * file: _p2pList.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-20
 * desc: 
 */
?>
<tr>
	<td><?php echo date('Y-n-j H:i:s',$data->getAttribute('time')); ?></td>
	<td><?php if($data->getAttribute('from_user') == $this->user->getId()){
		echo  $data->getRelated('toUser')->getAttribute('email');
	}else{
		echo  $data->getRelated('fromUser')->getAttribute('email'); 
	}?></td>
	<?php if($data->getAttribute('to_user') == NULL || $data->getAttribute('from_user') == $this->user->getId()){ ?>
	<td>
		<?php echo "-".number_format($data->getAttribute('sum') / 100,2); ?>元
	</td>
	<td>0.00元</td>
	<td>还款</td>
	<?php }else{ ?>
	<td>
		<?php echo number_format($data->getAttribute('sum') / 100,2); ?>元
	</td>
	<td><?php echo number_format($data->getAttribute('fee') / 100,2); ?>元</td>
	<td>收款</td>
	<?php } ?>
	<td></td>
</tr>