<?php
/**
 * @name categoryList.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-12 
 * Encoding UTF-8
 */
$pager = $dataProvider->getPagination();
$pageUrl = urlencode( $pager->createPageUrl($this,$pager->getCurrentPage()) );
?>
<table>
	<thead>
		<th>所属栏目</th>
		<th>分类名称</th>
		<th>描述</th>
		<th>操作</th>
	</thead>
	
	<tbody>
		<?php foreach ( $dataProvider->getData() as $data ):
		$params = array('id'=>$data->id,'redirect'=>$pageUrl);
		?>
		<tr>
			<td><?php echo $this->artTypeMap[$data->fid]?></td>
			<td><?php echo $data->category_name?></td>
			<td><?php echo $data->description?></td>
			<td>
				<a href="<?php echo $this->createUrl('content/categoryEdit',$params)?>">编辑</a>
				&nbsp;|
				<a class="deleteLink" href="<?php echo $this->createUrl('content/categoryDelete',$params)?>">删除</a>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>

<div class="pagination">
	<?php $this->renderPartial('/public/pager',array('pager'=>$pager))?>
</div>