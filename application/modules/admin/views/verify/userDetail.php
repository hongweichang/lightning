<h3>用户基本信息</h3>
<table>
	<tbody>
		<tr>
			<td>用户昵称</td>
			<td><?php echo $userData[0]->nickname;?></td>
		</tr>
		<tr>
			<td>用户真实姓名</td>
			<td><?php echo $userData[0]->realname;?></td>
		</tr>
		<tr>
			<td>用户性别</td>
			<td>
				<?php
                  if($userData[0]->gender == ''){
                     echo "保密";                       
                  }else{
                         if($userData[0]->gender == '1')
                             echo "男";
                         if($userData[0]->gender == '0')
                             echo "女"; 
                        }					 
				?>
			</td>
		</tr>
		<tr>
			<td>用户身份证号</td>
			<td><?php echo $userData[0]->identity_id;?></td>
		</tr>
		<tr>
			<td>用户角色</td>
			<td><?php echo FrontUser::getRoleName($userData[0]->role);?></td>
		</tr>
		<tr>
			<td>用户手机号</td>
			<td><?php echo $userData[0]->mobile;?></td>
		</tr>
		<tr>
			<td>用户邮箱</td>
			<td><?php echo $userData[0]->email;?></td>
		</tr>
		<tr>
			<td>用户居住地址</td>
			<td><?php echo $userData[0]->address?></td>
		</tr>
	</tbody>
</table>

<h3>用户信用资料</h3>
<table>
	<tbody>
		<?php foreach($userCredit as $value){?>
		<tr>
			<td><?php echo $value['verification_name'];?><td>
			<?php
				if(!empty($value['fileUrl'])){
			 ?>
			 <td><img src="<?php echo $value['fileUrl']?>" style="width:400px;height:300px";/></td>
			 <td><a href="<?php echo $this->createUrl('Download',array('id'=>$value['id']))?>">下载图片</a></td>	
			<?php }else{
			?>
			<td><a href="<?php echo $this->createUrl('Download',array('id'=>$value['id']))?>">下载附件</a></td>
			<?php }?>
		</tr>
		<?php }?>
	</tbody>
</table>

<h3>该标段是否通过审核？</h3>
<label>
<a href="<?php echo Yii::app()->createUrl('adminnogateway/verify/bidVerify',array(
            'action'=>'pass','id'=>$id))?>"  
   class="check" data-method="check-pass">审核通过
</a>
</label>
<label>
<a href="<?php echo Yii::app()->createUrl('adminnogateway/verify/bidVerify',array(
            'action'=>'unpass','id'=>$id))?>" 
   class="check" data-method="check-pass">审核不通过
</a>
</label>