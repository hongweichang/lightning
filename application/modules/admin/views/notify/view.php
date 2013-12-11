<?php
/**
 * @name view.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-11 
 * Encoding UTF-8
 */
$pager = $dataProvider->getPagination();
$pageUrl = urlencode( $pager->createPageUrl($this,$pager->getCurrentPage()) );
$data = $dataProvider->getData();
$name = $type === 'email' ? '邮件规则' : '短信规则';
$this->addToSubTab('添加'.$name,'notify/add'.ucfirst($type));
?>
<table>
	<thead>
		<th>事件</th>
		<th>是否启用</th>
		<th>操作</th>
	</thead>
	
	<tbody>
	<?php foreach ( $data as $d ):
		$params = array('id'=>$d->id,'redirect'=>$pageUrl);
	?>
		<tr>
			<td><?php echo $d->event_name;?></td>
			<td><?php echo $d->enabled == 1 ? '是' : '否'?></td>
			<td>
				<a href="<?php echo $this->createUrl('notify/edit'.ucfirst($type),$params);?>">修改</a>
			</td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>

<div class="pagination">
	<?php $this->renderPartial('/public/pager',array('pager'=>$pager))?>
</div>