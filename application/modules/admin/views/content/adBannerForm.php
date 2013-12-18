<?php
/**
 * @name adBannerForm.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-13 
 * Encoding UTF-8
 */
$form=$this->beginWidget('CActiveForm',array(
		'focus' => array($model,'scheme_name'),
		'action' => $action,
		'htmlOptions' => array(
				'enctype' => 'multipart/form-data'
		)
));
if ( $model->hasErrors() )
	$this->addNotifications($form->errorSummary($model),'error');

$fileString = $this->renderPartial('bannerFile',array('form'=>$form,'model'=>$model),true);
$this->cs->registerScript('addBannerFile','
$("#bannerButton").click(function(){
	$("#bannerFiles").append(\''.$fileString.'\');
})
');
?>

<p>
	<label>方案标题*</label>
	<?php echo $form->textField($model,'scheme_name',array('class'=>'text-input small-input'));?>
	<br />
	<small>填写方案标题</small>
</p>

<p>
	<label>描述</label>
	<small>填写方案描述</small>
	<?php echo $form->textArea($model,'description',array('class'=>'text-input textarea'));?>
</p>

<p>
	<label>添加banner图片</label>
	<div id="bannerButton">
		<img id="addBannerButton" title="添加图片" src="<?php echo $this->imageUrl.'icons/add.png'?>" />
		<label>点击添加图片</label>
	</div>
</p>

<div id="bannerFiles">
	<?php $this->renderPartial('bannerFile',array('form'=>$form,'model'=>$model))?>
</div>

<p>
	<?php echo CHtml::submitButton(' 确 定 ',array('class'=>'button'))?>
</p>

<?php $this->endWidget()?>