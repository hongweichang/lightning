<?php
/**
 * @name categoryForm.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-12 
 * Encoding UTF-8
 */
$form=$this->beginWidget('CActiveForm',array(
		'focus' => array($model,'category_name'),
		'action' => $action
));
if ( $model->hasErrors() )
	$this->addNotifications($form->errorSummary($model),'error');
?>

<p>
	<label>分类名称*</label>
	<?php echo $form->textField($model,'category_name',array('class'=>'text-input small-input'));?>
	<br />
	<small>填写分类名称</small>
</p>

<p>
	<label>描述</label>
	<?php echo $form->textArea($model,'description',array('class'=>'text-input textarea wysiwyg','id'=>'notifyContent'));?>
	<br />
	<small>请输入分类描述</small>
</p>

<p>
	<?php echo CHtml::submitButton(' 确 定 ',array('class'=>'button'))?>&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo '';//CHtml::link(CHtml::button(' 返 回 ',array('class'=>'button')),Yii::app()->createUrl('admin/index/welcome'))?>
</p>

<?php $this->endWidget()?>