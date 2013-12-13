<?php
/**
 * @name add.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-12 
 * Encoding UTF-8
 */
if ( $type === 'email' ){
	$this->widget('cms.extensions.kindeditor.KindEditorWidget',array(
			'id' => 'notifyContent',
			'items' => array(
					'height' => '250px'
			),
			'assets' => 'cms.extensions.kindeditor.assets'
	));
}
$form=$this->beginWidget('CActiveForm',array(
		'focus' => array($model,'account'),
		'action' => $this->createUrl('notify/add'.ucfirst($type),$urlParams)
));

if ( $model->hasErrors() )
	$this->addNotifications($form->errorSummary($model),'error');
?>

<p>
	<label>事件*</label>
	<?php echo $form->textField($model,'event',array('class'=>'text-input small-input'));?>
	<br />
	<small>填写事件</small>
</p>

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
	<label>占位符</label>
	<?php echo $form->textField($model,'placeholders',array('class'=>'text-input small-input'));?>
	<br />
	<small>填写占位符</small>
</p>

<p>
	<label>通知内容*</label>
	<?php echo $form->textArea($model,'content',array('class'=>'text-input textarea wysiwyg','id'=>'notifyContent'));?>
	<br />
	<small>请输入通知内容</small>
</p>

<p>
	<?php echo CHtml::submitButton(' 确 定 ',array('class'=>'button'))?>&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo '';//CHtml::link(CHtml::button(' 返 回 ',array('class'=>'button')),Yii::app()->createUrl('admin/index/welcome'))?>
</p>

<?php $this->endWidget()?>