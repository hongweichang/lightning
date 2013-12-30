<table>
	<tbody>
		<tr>
			<td><label>用户昵称</label></td>
			<td><label>用户姓名</label></td>
			<td><label>用户手机</label></td>
			<td><label>用户邮箱</label></td>
			<td><label></label></td>
		</tr>
		<?php foreach($userData as $value){?>
		<tr>
			<td><?php echo $value->getRelated('user')->nickname;?></td>
			<td><?php echo $value->getRelated('user')->realname;?></td>
			<td><?php echo $value->getRelated('user')->mobile;?></td>
			<td><?php echo $value->getRelated('user')->email;?></td>
		</tr>
		<?php }?>
	</tbody>
</table>