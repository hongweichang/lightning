<?php
/**
 * @name editContract.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2014-1-19 
 * Encoding UTF-8
 */
?>
<form action="<?php echo $this->createUrl('') ?>" method="post">
<p>
	<label>内容*</label>
	<small>填写文章内容</small>
	<?php 
	$this->widget('cms.extensions.eckeditor.ECKEditor', array(
			'model'=>$model,
			'attribute'=>'content'));
	?>
</p>

<p>
	<?php echo CHtml::submitButton(' 确 定 ',array('class'=>'button'))?>
</p>
</form>