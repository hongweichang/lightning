<?php
/**
 * @name view.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-5
 * Encoding UTF-8
 */
?>
<div class="table-list">
		<table width="100%" cellspacing="0" id="tree">
			<thead>
				<tr>
					<th width="8%">id</th>
					<th width="15%">用户组名称</th>
					<th width="20%">用户组描述</th>
					<th width="20%">管理操作</th>
				</tr>
			</thead>
			
			<tbody>
			<?php foreach ( $list as $data ):?>
				<tr>
					<td><?php echo $data->primaryKey;?></td>
					<td><?php echo $data->group_name;?></td>
					<td><?php echo $data->description;?></td>
					<td>
						<a href="<?php echo $this->createUrl('/accessManage/assignment/groupRole',array('group'=>$data->primaryKey))?>">角色授权</a> | 
						<a href="<?php echo $this->createUrl('group/edit',array('id'=>$data->primaryKey))?>">编辑</a> | 
						<a href="<?php echo $this->createUrl('group/delete',array('id'=>$data->primaryKey))?>">删除</a>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
<?php 
	$this->renderPartial('//common/pager',array('pager'=>$pager));
?>
</div>