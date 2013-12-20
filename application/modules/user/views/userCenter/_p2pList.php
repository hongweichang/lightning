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
	<td><?php if($data->getAttribute('to_user') == NULL || $data->getAttribute('from_user') == $this->user->getId()){
		echo "-".number_format($data->getAttribute('sum') / 100,2); 
	}else{
		echo number_format($data->getAttribute('sum') / 100,2);
	} ?></td>
	<td><?php echo number_format($data->getAttribute('fee') / 100,2); ?></td>
	<td><?php echo "即时到帐"; ?></td>
	<td></td>
</tr>