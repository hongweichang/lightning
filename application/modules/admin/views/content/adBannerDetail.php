<?php
/**
 * @name adBannerDetail.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-14 
 * Encoding UTF-8
 */
$return = CHtml::link(CHtml::button(' 返 回 ',array('class'=>'button')),$redirect);
?>
<form>
	<p>
	<?php echo $return?>
	</p>
	
	<p>
		<label>方案标题</label>
		<?php echo $model->scheme_name?>
	</p>
	
	<p>
		<label>描述</label>
		<?php echo empty($model->description) ? '无' : $model->description?>
	</p>
	
	<p>
		<label>是否启用</label>
		<?php echo $model->is_using == 1 ? '是' : '否'?>
	</p>
	
	<p>
		<label >图片</label>
	</p>
	
	<?php foreach ( $files as $count => $file ):?>
	<p>
		<label><?php echo $count+1?>.图片标题--<?php echo $file['title']?></label>
		<label>&nbsp;&nbsp;&nbsp;<a href="<?php echo $file['redirect']?>" target="_blank">链接地址--<?php echo $file['redirect']?></a></label>
		<img width="100%" src="<?php echo $file['filename']?>" />
	</p>
	<?php endforeach;?>
	
	<p>
	<?php echo $return?>
	</p>
</form>