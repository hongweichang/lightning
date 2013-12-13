<?php
/**
 * @name articleForm.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-12 
 * Encoding UTF-8
 */
$this->widget('cms.extensions.kindeditor.KindEditorWidget',array(
		'id' => 'artContent',
		'items' => array(
				'height' => '450px',
		),
		'assets' => 'cms.extensions.kindeditor.assets'
));

$form=$this->beginWidget('CActiveForm',array(
		'focus' => array($model,'category_name'),
		'action' => $action
));
if ( $model->hasErrors() )
	$this->addNotifications($form->errorSummary($model),'error');
?>

<p>
	<label>标题*</label>
	<?php echo $form->textField($model,'title',array('class'=>'text-input small-input'));?>
	<br />
	<small>填写分标题</small>
</p>

<p>
	<label>分类*</label>
	<?php echo $form->dropdownList($model,'category',$model->allCategories,array('class'=>''));?>
	<br />
	<small>选择文章分类</small>
</p>

<p>
	<label>内容*</label>
	<small>填写文章内容</small>
	<?php echo $form->textArea($model,'content',array('class'=>'text-input textarea wysiwyg','id'=>'artContent'));?>
</p>

<p>
	<?php echo CHtml::submitButton(' 确 定 ',array('class'=>'button'))?>
</p>

<?php $this->endWidget()?>