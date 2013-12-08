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
					<th width="15%">操作名称</th>
					<th width="10%">模块名称</th>
					<th width="10%">控制器名称</th>
					<th width="10%">动作名称</th>
					<th width="20%">操作描述</th>
					<th width="20%">管理操作</th>
				</tr>
			</thead>
			
			<tbody align="center">
				<?php foreach ( $list as $l ):?>
				<tr data-tt-id="<?php echo $l['parent']->primaryKey;?>"><?php 
						$lEditUrl = $this->createUrl('operation/edit',array('id'=>$l['parent']->primaryKey));
						$lDelUrl = $this->createUrl('operation/delete',array('id'=>$l['parent']->primaryKey));
					?>
					<td><?php echo $l['parent']->primaryKey?></td>
					<td><?php echo $l['parent']->operation_name?></td>
					<td><?php echo $l['parent']->module?></td>
					<td><?php echo $l['parent']->controller?></td>
					<td><?php echo $l['parent']->action?></td>
					<td><?php echo $l['parent']->description?></td>
					<td>
						<a href="<?php echo $lEditUrl?>">修改</a> | 
						<a href="<?php echo $lDelUrl?>">删除</a>
					</td>
				</tr>
					<?php foreach( $l['children'] as $lc ):?>
				<tr data-tt-id="<?php echo $lc['parent']->primaryKey;?>" data-tt-parent-id="<?php echo $l['parent']->primaryKey;?>"><?php 
						$lcEditUrl = $this->createUrl('operation/edit',array('id'=>$lc['parent']->primaryKey));
						$lcDelUrl = $this->createUrl('operation/delete',array('id'=>$lc['parent']->primaryKey));
					?>
					<td><?php echo $lc['parent']->primaryKey?></td>
					<td><?php echo $lc['parent']->operation_name?></td>
					<td><?php echo $lc['parent']->module?></td>
					<td><?php echo $lc['parent']->controller?></td>
					<td><?php echo $lc['parent']->action?></td>
					<td><?php echo $lc['parent']->description?></td>
					<td>
						<a href="<?php echo $lcEditUrl?>">修改</a> | 
						<a href="<?php echo $lcDelUrl?>">删除</a>
					</td>
				</tr>
						<?php foreach( $lc['children'] as $lcc ):?>
				<tr data-tt-id="<?php echo $lcc->primaryKey;?>" data-tt-parent-id="<?php echo $lc['parent']->primaryKey;?>"><?php 
						$lccEditUrl = $this->createUrl('operation/edit',array('id'=>$lcc->primaryKey));
						$lccDelUrl = $this->createUrl('operation/delete',array('id'=>$lcc->primaryKey));
					?>
					<td><?php echo $lcc->primaryKey?></td>
					<td><?php echo $lcc->operation_name?></td>
					<td><?php echo $lcc->module?></td>
					<td><?php echo $lcc->controller?></td>
					<td><?php echo $lcc->action?></td>
					<td><?php echo $lcc->description?></td>
					<td>
						<a href="<?php echo $lccEditUrl?>">修改</a> | 
						<a href="<?php echo $lccDelUrl?>">删除</a>
					</td>
				</tr>
						<?php endforeach;?>
					<?php endforeach;?>
				<?php endforeach;?>
			</tbody>
			
		</table>
</div>