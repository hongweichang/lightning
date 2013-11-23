<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'userInfo-form',
	'enableAjaxValidation'=>true,
)); ?>
<?php echo $form->labelEx($model,'description'); ?>
<?php echo $form->textArea($model,'description',array('class'=>'form-input-textarea')); ?>
<?php echo CHtml::submitButton($model->isNewRecord ? '提交' : '保存修改',array('id'=>'reply','name'=>'submit','class'=>'form-button form-button-submit')); ?>

<?php $this->endWidget(); ?>