<?php
/**
 * @name articleList.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-12 
 * Encoding UTF-8
 */
$pager = $dataProvider->getPagination();
$pageUrl = urlencode( $pager->createPageUrl($this,$pager->getCurrentPage()) );
$typeName = $type == 0 ? 'article' : 'officialHelp';
?>
<table>
	<thead>
		<th>标题</th>
		<th>添加时间</th>
		<th>发布管理员</th>
		<th>所属栏目</th>
		<th>查看</th>
		<th>操作</th>
	</thead>
	<?php foreach ( $dataProvider->getData() as $data ):
	$params = array('id'=>$data->id,'redirect'=>$pageUrl);
	?>
		<tr>
			<td><?php echo $data->title;?></td>
			<td><?php echo date('Y/m/d H:s',$data->add_time)?></td>
			<td><?php echo $data->admin_name?></td>
			<td><?php echo $data->getRelated('category')->category_name?></td>
			<td><a href="<?php echo $this->createUrl('/content/article/view',array('id'=>$data->id))?>" target="_blank">点击查看</a></td>
			<td>
				<a href="<?php echo $this->createUrl('content/'.$typeName.'Edit',$params)?>">编辑</a>
				&nbsp;|
				<a class="deleteLink" href="<?php echo $this->createUrl('content/'.$typeName.'Delete',$params)?>">删除</a>
			</td>
		</tr>
	<?php endforeach;?>
	<tbody>
	</tbody>
</table>

<div class="pagination">
	<?php $this->renderPartial('/public/pager',array('pager'=>$pager))?>
</div>