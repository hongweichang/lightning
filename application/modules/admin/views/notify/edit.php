<?php
/**
 * @name edit.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-11 
 * Encoding UTF-8
 */
$form=$this->beginWidget('CActiveForm',array(
		'focus' => array($model,'account'),
		'action' => $this->createUrl('notify/edit'.ucfirst($type),$urlParams)
));

$placeholders = $this->getFormatPlaceholders($model->placeholders);
if ( $placeholders !== '' ){
	$this->addNotifications($placeholders);
}

if ( $model->hasErrors() )
$this->addNotifications($form->errorSummary($model),'error');
?>

<p>
	<label>事件名称*</label>
	<?php echo $form->textField($model,'event_name',array('class'=>'text-input small-input'));?>
	<br />
	<small>填写事件名称</small>
</p>

<p>
	<label>开启和关闭</label>
	<?php echo $form->radioButtonList($model,'enabled',array(1=>'开启',0=>'关闭'),array('class'=>''));?>
</p>

<p>
	<label>通知内容*</label>
	<?php 
	if ( $type === 'email' ){
		$this->widget('cms.extensions.eckeditor.ECKEditor', array(
				'model'=>$model,
				'attribute'=>'content', ));
	}else {
		echo $form->textArea($model,'content',array('class'=>'text-input textarea','id'=>'notifyContent'));
	}?>
	<br />
	<small>请输入通知内容</small>
</p>

<p>
	<?php echo CHtml::submitButton(' 确 定 ',array('class'=>'button'))?>&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo '';//CHtml::link(CHtml::button(' 返 回 ',array('class'=>'button')),Yii::app()->createUrl('admin/index/welcome'))?>
</p>

<?php $this->endWidget()?>