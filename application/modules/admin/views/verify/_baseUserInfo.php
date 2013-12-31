<h3>用户基本信息</h3>
<table>
	<tbody>
		<tr>
			<td>用户昵称</td>
			<td><?php echo $data->nickname;?></td>
		</tr>
		<tr>
			<td>用户真实姓名</td>
			<td><?php echo $data->realname;?></td>
		</tr>
		<tr>
			<td>用户性别</td>
			<td>
				<?php
                  if($data->gender == ''){
                     echo "保密";                       
                  }else{
                         if($data->gender == '1')
                             echo "男";
                         if($data->gender == '0')
                             echo "女"; 
                        }					 
				?>
			</td>
		</tr>
		<tr>
			<td>用户身份证号</td>
			<td><?php echo $data->identity_id;?></td>
		</tr>
		<tr>
			<td>用户角色</td>
			<td><?php echo FrontUser::getRoleName($data->role);?></td>
		</tr>
		<tr>
			<td>用户手机号</td>
			<td><?php echo $data->mobile;?></td>
		</tr>
		<tr>
			<td>用户邮箱</td>
			<td><?php echo $data->email;?></td>
		</tr>
		<tr>
			<td>用户居住地址</td>
			<td><?php echo $data->address?></td>
		</tr>
	</tbody>
</table>