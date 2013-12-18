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

?>

<p>
	<label>方案标题*</label>
	<?php echo $form->textField($model,'scheme_name',array('class'=>'text-input small-input'));?>
	<br />
	<small>请填写方案标题</small>
</p>

<p>
	<label>详情</label>
	<?php echo $form->textArea($model,'description',array('class'=>'text-input textarea'));?>
</p>

<p>
	<label>图片标题*</label>
	<small>图片标题将在app端显示</small>
	<br />
	<?php echo $form->textField($model,'file_titles[]',array('class'=>'text-input small-input'));?>
</p>

<p>
	<label>图片文件*</label>
	<?php echo $form->fileField($model,'files[]',array('class'=>'file'))?>
</p>

<p>
	<?php echo CHtml::submitButton(' 确 定 ',array('class'=>'button'))?>
</p>

<?php $this->endWidget()?>