<?php
/**
 * @name faqReplyView.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-16 
 * Encoding UTF-8
 */
$form=$this->beginWidget('CActiveForm',array(
		'focus' => array($model,'content'),
		'action' => $action
));
if ( $model->hasErrors() )
	$this->addNotifications($form->errorSummary($model),'error');

$userData = $userDataProvider->getData();
$userData = $userData[0];
?>

<p>
	<label>用户留言</label>
	用户 <?php echo $userData->getUser()->nickname?> 于 <?php echo date('Y-m-d H:i',$userData->add_time)?>留言
	<br />内容：<?php echo $userData->content?>
</p>

<p>
	<label>回复内容</label>
	<?php echo $form->textArea($model,'content',array('class'=>'text-input textarea wysiwyg','id'=>'notifyContent'));?>
	<br />
	<small>请输入回复内容</small>
</p>

<p>
	<?php echo CHtml::submitButton(' 确 定 ',array('class'=>'button'))?>
</p>

<p>
	<label>历史回复</label>
</p>

<?php foreach ( $dataProvider->getData() as $data ):?>
	管理员 <?php echo $data->getUser()->nickname?> 于 <?php echo date('Y-m-d H:i',$data->add_time) ?>回复：<?php echo $data->content?>
	<br /><br />
<?php endforeach;?>
<?php $this->endWidget()?>