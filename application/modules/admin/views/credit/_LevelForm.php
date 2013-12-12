<?php
/*
**会员级别表单
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'level-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'class' => 'form-list'
	)
));
?>
<p><label>会员等级名称</label></p>
<?php echo $form->textField($model,'label');?>
<p><label>该等级最低分数</label></p>
<?php echo $form->textField($model,'start');?>
<p><label>充值利率</label></p>
<?php echo $form->textField($model,'on_recharge').'%';?>
<p><label>提现利率</label></p>
<?php echo $form->textField($model,'on_withdraw').'%';?>
<p><label>还款利率</label></p>
<?php echo $form->textField($model,'on_pay_back').'%';?>
<p><label>借款大于6个月利率</label></p>
<?php echo $form->textField($model,'on_over6').'%';?>
<p><label>借款小于6个月利率</label></p>
<?php echo $form->textField($model,'on_below6').'%';?>
<p><label>标段利息利润利率</label></p>
<?php echo $form->textField($model,'on_loan').'%';?>
<p><label>该等级是否能借款</label></p>
<?php echo $form->dropDownList($model,'loanable',array(
									'0'=>'不能',
									'1'=>'能'
								))?>
<br/>
<?php echo CHtml::submitButton($model->isNewRecord ? '提交' : '保存修改',array('id'=>'reply','name'=>'submit')); ?>
<?php $this->endWidget();?>