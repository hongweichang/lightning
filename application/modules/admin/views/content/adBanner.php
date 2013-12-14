<?php
/**
 * @name adBanner.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-13 
 * Encoding UTF-8
 */
$pager = $dataProvider->getPagination();
$pageUrl = urlencode( $pager->createPageUrl($this,$pager->getCurrentPage()) );
?>
<table>
	<thead>
		<th>方案标题</th>
		<th>图片数量</th>
		<th>是否启用</th>
		<th>操作</th>
	</thead>
	
	<tbody>
		<?php foreach ( $dataProvider->getData() as $data ):
		$params = array('id'=>$data->id,'redirect'=>$pageUrl);
		?>
		<tr>
			<td><?php echo $data->scheme_name?></td>
			<td><?php echo count($data->file_names)?></td>
			<td><?php echo $data->is_using != 0 ? '是' : '否'?></td>
			<td>
				<a href="<?php echo $this->createUrl('content/adBannerEnable',$params)?>"><?php echo $data->is_using == 0 ? '启用' : '停用'?></a>
				&nbsp;|
				<a href="<?php echo $this->createUrl('content/adBannerDetail',$params)?>">查看</a>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>

<div class="pagination">
	<?php $this->renderPartial('/public/pager',array('pager'=>$pager))?>
</div>