<?php
/**
 * @name view.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-3
 * Encoding UTF-8
 */
?>

<div class="table-list">
		<table width="100%" cellspacing="0" id="tree">
			<thead>
				<tr>
					<th width="8%">id</th>
					<th width="15%">角色名称</th>
					<th width="20%">角色描述</th>
					<th width="20%">管理操作</th>
				</tr>
			</thead>
			
			<tbody align="center"><?php foreach ( $list as $l ):?>
				<tr>
					<td><?php echo $l->primaryKey;?></td>
					<td><?php echo $l->role_name;?></td>
					<td><?php echo $l->description?></td>
					<td>
						<a href="<?php echo $this->createUrl('assignment/permission',array('role'=>$l->primaryKey));?>">操作授权</a> |
						<a href="<?php echo $this->createUrl('role/edit',array('id'=>$l->primaryKey));?>">修改</a> | 
						<a href="<?php echo $this->createUrl('role/delete',array('id'=>$l->primaryKey))?>">删除</a>
					</td>
				</tr>
			<?php endforeach?>
			</tbody>
			
		</table>
</div>