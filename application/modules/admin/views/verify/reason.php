<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'userInfo-form',
	'enableAjaxValidation'=>true,
)); ?>
<?php echo $form->labelEx($model,'审核不通过原因输入'); ?>
<?php echo $form->textArea($model,'description',array('class'=>'text-input textarea')); ?>
<?php echo CHtml::submitButton('提交',array('id'=>'reply','name'=>'submit','class'=>'button')); ?>

<?php $this->endWidget(); ?>