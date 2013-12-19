<?php
/**
 * @name faq.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-16 
 * Encoding UTF-8
 */
$pager = $dataProvider->getPagination();
$pageUrl = urlencode( $pager->createPageUrl($this,$pager->getCurrentPage()) );
$action = $type == 0 ? 'faq' : 'userMessage';
?>
<table>
	<thead>
		<th>内容</th>
		<th>时间</th>
		<th>用户昵称</th>
		<th>留言IP</th>
		<th>操作</th>
	</thead>
	
	<tbody>
	<?php foreach ( $dataProvider->getData() as $data ):
	$params = array('id'=>$data->id,'redirect'=>$pageUrl);
	?>
		<tr>
			<td><?php 
				$content = $data->content;
				$len = strlen($content);
				if ( $len >= 23 ):
					$content = mb_substr($content,0,20,'UTF-8').'......';
				endif;
				echo $content;
			?></td>
			<td><?php echo date('Y/m/d H:i',$data->add_time)?></td>
			<td><?php echo $data->getUser()->nickname?></td>
			<td><?php echo $data->add_ip?></td>
			<td>
				<a href="<?php echo $this->createUrl('content/'.$action.'Reply',$params)?>">查看与回复</a>
				&nbsp;|
				<a href="<?php echo $this->createUrl('content/'.$action.'Delete',$params)?>">删除</a>
			</td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>