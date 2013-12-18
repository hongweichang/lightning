<?php
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'credit-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'class' => 'form-list'
	)
));
?>
<p><label>信用项标题</label></p>
<?php echo $form->textField($Creditmodel,'verification_name');?>
<p><label>信用项简介</label></p>
<?php echo $form->textArea($Creditmodel,'description');?>
<p><label>信用积分</label></p>
<?php echo $form->textField($Rolemodel,'grade');?>
<p><label>角色选择</label></p>
<?php echo $form->checkBoxList($Rolemodel,'role',array(
					'wddz'=>'网店店主',
					'gxjc'=>'工薪阶层',
					'qyz'=>'企业主'

			),array(
			'template'=>'{label} {input}',
			'separator'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			//'class'=>'labelForRadio'
			));?>



<?php echo CHtml::submitButton($Creditmodel->isNewRecord ? '提交' : '保存修改',array('id'=>'reply','name'=>'submit')); ?>


<?php $this->endWidget();?>