<?php
/*
**债权表单
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/
$this->cs->registerScriptFile($this->scriptUrl.'datepicker.js',CClientScript::POS_HEAD);
$this->cs->registerCssFile($this->cssUrl.'datepicker.css');
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'level-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'class' => 'form-list'
	)
));
?>

<p><label>债权标题</label></p>
<?php echo $form->textField($model,'title',array('class'=>'text-input'));?>
<p><label>债权简介</label></p>
<?php echo $form->textArea($model,'description',array('class'=>'text-input textarea'));?>
<p><label>债权人信息</label></p>
<?php echo $form->textArea($model,'Debt_master',array('class'=>'text-input textarea'));?>
<p><label>获利方式</label></p>
<?php echo $form->textArea($model,'incomeWay',array('class'=>'text-input textarea'));?>
<div class="input-daterange" id="datepicker">
<p><label>开始时间</label></p>
<?php echo $form->textField($model,'start',array('class'=>'input-small'));?>
<p><label>结束时间</label></p>
<?php echo $form->textField($model,'end',array('class'=>'input-small'));?>
</div>
<p><label>加入条件</label></p>
<?php echo $form->textArea($model,'condition',array('class'=>'text-input textarea'));?>
<p><label>期限</label></p>
<?php echo $form->textField($model,'deadline',array('class'=>'text-input ')).'个月';?>
<p><label>费用</label></p>
<?php echo $form->textArea($model,'charge',array('class'=>'text-input textarea'));?>
<p><label>保障方式</label></p>
<?php echo $form->textArea($model,'protection',array('class'=>'text-input textarea'));?>
<p><label>备注</label></p>
<?php echo $form->textArea($model,'remark',array('class'=>'text-input textarea'));?>

<?php echo CHtml::submitButton($model->isNewRecord ? '提交' : '保存修改',array('id'=>'reply','name'=>'submit','class'=>"button")); ?>
<?php $this->endWidget();?>
<script type="text/javascript">
	$('.input-daterange').datepicker({
	    startDate: "today",
	    language: "zh-CN",    
	    todayHighlight: true
	});
</script>
