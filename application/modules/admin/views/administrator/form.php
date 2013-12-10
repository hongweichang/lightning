<?php
/**
 * @name form.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-10 
 * Encoding UTF-8
 */
$form=$this->beginWidget('CActiveForm',array(
		'focus' => array($model,'account'),
		'action' => $action
));
?>
<?php 
if ( $model->hasErrors() )
$this->addNotifications($form->errorSummary($model),'error');
?>

<p>
	<label>帐号</label>
	<?php echo $form->textField($model,'account',array('class'=>'text-input small-input'));?>
	<br />
	<small>填写登录帐号</small>
</p>

<p>
	<label>昵称</label>
	<?php echo $form->textField($model,'nickname',array('class'=>'text-input small-input'));?>
	<br />
	<small>填写昵称</small>
</p>

<p>
	<label>密码</label>
	<?php echo $form->passwordField($model,'password',array('class'=>'text-input small-input'));?>
	<br />
	<small>填写密码</small>
</p>

<p>
	<?php echo CHtml::submitButton(' 确 定 ',array('class'=>'button'))?>&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo '';//CHtml::link(CHtml::button(' 返 回 ',array('class'=>'button')),Yii::app()->createUrl('admin/index/welcome'))?>
</p>

<?php $this->endWidget()?>