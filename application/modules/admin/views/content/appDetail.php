<?php
/**
 * @name appDetail.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-15 
 * Encoding UTF-8
 */
$return = CHtml::link(CHtml::button(' 返 回 ',array('class'=>'button')),$redirect);
$file = $files[0];
$img = '<img width="100%" src="'.$file['filename'].'" />';
?>
<form>
	<p>
	<?php echo $return?>
	</p>
	
	<p>
		<label>方案标题--<?php echo $model->is_using == 1 ? '已启用' : '未启用'?></label>
		<?php echo $model->scheme_name?>
	</p>
	
	<p>
		<label >图片</label>
		<?php echo $img?>
	</p>
	
	<p>
		<label>标题</label>
		<?php echo $file['title']?>
	</p>
	
	<p>
		<label>详情</label>
		<?php echo empty($model->description) ? '无' : $model->description?>
	</p>
	
</form>

<div class="content-box column-left banner-detail-left">
	<div class="content-box-header">
		<h3 style="cursor: s-resize;">Banner预览效果</h3>
	</div>
	
	<div class="content-box-content">
		<div class="banner-container">
			<?php echo $img?>
			<div class="banner-title-under-img">
				标题-<?php echo $file['title']?>
			</div>
		</div>
	</div>
</div>

<div class="content-box column-right banner-detail-right">
	<div class="content-box-header">
		<h3 style="cursor: s-resize;">新闻页面显示预览效果</h3>
	</div>
	
	<div class="content-box-content">
		<div class="banner-container">
			<div class="banner-title-above-img">
				标题-<?php echo $file['title']?>
			</div>
			<?php echo $img?>
			<div class="banner-description-under-img">
				详情 - <?php echo empty($model->description) ? '无' : $model->description?>
			</div>
		</div>
	</div>
</div>