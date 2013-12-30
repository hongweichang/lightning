<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'userInfo-form',
)); ?>
<?php echo $form->labelEx($model,'审核不通过理由'); ?>
<?php echo $form->textArea($model,'failed_description',array('class'=>'text-input textarea')); ?>
<?php echo CHtml::submitButton('提交',array('id'=>'reply','name'=>'submit','class'=>'button form-button-submit')); ?>

<?php $this->endWidget(); ?>