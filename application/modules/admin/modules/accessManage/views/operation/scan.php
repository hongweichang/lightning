<?php
/**
 * @name scan.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-9
 * Encoding UTF-8
 */
?>
<div class="table-list">
		<table width="100%" cellspacing="0" id="tree">
			<thead>
				<tr>
					<th width="10%">模块名称</th>
					<th width="10%">控制器名称</th>
					<th width="10%">动作名称</th>
					<th width="20%">管理</th>
				</tr>
			</thead>
			
			<tbody align="center">
			<?php foreach ( $map as $m ):?>
				<tr>
					<td><?php echo $m['module']?></td>
					<td><?php echo $m['controller']?></td>
					<td><?php echo $m['action']?></td>
					<td>
						<a href="<?php echo $this->createUrl('',array(
								'click'=>1,
								'module'=>$m['module'],
								'controller'=>$m['controller'],
								'action'=>$m['action']))?>">添加</a>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
</div>