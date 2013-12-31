<?php
/**
 * @name form.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-31 
 * Encoding UTF-8
 */
$form=$this->beginWidget('CActiveForm',array(
		'focus' => array($model,'frontUser'),
		'action' => $action
));
if ( $model->hasErrors() )
	$this->addNotifications($form->errorSummary($model),'error');
?>

<p>
	<label>昵称*</label>
	<?php echo $form->textField($model,'nickname',array('class'=>'text-input small-input'));?>
</p>

<p>
	<label>姓名*</label>
	<?php echo $form->textField($model,'realname',array('class'=>'text-input small-input'));?>
</p>

<p>
	<label>密码*</label>
	<?php echo $form->passwordField($model,'password',array('class'=>'text-input small-input'));?>
	<br />
	<small>不修改请留空</small>
</p>

<p>
	<label>手机号码*</label>
	<?php echo $form->textField($model,'mobile',array('class'=>'text-input small-input'));?>
</p>

<p>
	<label>邮箱*</label>
	<?php echo $form->textField($model,'email',array('class'=>'text-input small-input'));?>
</p>

<p>
	<label>身份证号*</label>
	<?php echo $form->textField($model,'identity_id',array('class'=>'text-input small-input'));?>
</p>

<p>
	<?php echo CHtml::submitButton(' 确 定 ',array('class'=>'button'))?>
</p>

<?php $this->endWidget()?>