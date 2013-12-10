<?php
/* @var $this AdvertiserController */
/* @var $model Advertiser */
/* @var $form CActiveForm */
?>

<div class="form-list">
<?php
	$this->widget('application.extensions.swfupload.CSwfUpload', array(
    'jsHandlerUrl'=>Yii::app()->request->baseUrl."/plugins/swfupload/js/handlers.js", //配置swfupload事件的js文件
    'postParams'=>array('PHPSESSID'=>Yii::app()->session->sessionID),//由于flash上传不可以传递cookie只能将session_id用POST方式传递
    'config'=>array(
    	//'debug'=>true,//是否开启调试模式
        'use_query_string'=>true,
        'upload_url'=>$this->createUrl('userInfo/upload'), //对应处理图片上传的controller/action
        'file_size_limit'=>'30 MB',//文件大小限制
        'file_types'=>'*.jpg;*.png;*.gif;*.jpeg;*.pdf;*.zip;*.rar',//文件格式限制
        'file_types_description'=>'Files',
        'file_upload_limit'=>1,
        'file_queue_limit'=>0,//一次上传文件个数
        'file_queue_error_handler'=>'js:fileQueueError',
        'file_dialog_complete_handler'=>'js:fileDialogComplete',
        'upload_progress_handler'=>'js:uploadProgress',
        'upload_error_handler'=>'js:uploadError',
        'upload_success_handler'=>'js:uploadSuccess',
        'upload_complete_handler'=>'js:uploadComplete',
        'custom_settings'=>array('upload_target'=>'divFileProgressContainer'),
        'button_placeholder_id'=>'swfupload',
        'button_width'=>140,
        'button_height'=>28,
        'button_image_url'=> $this->imageUrl.'upload_button.png',
        //'button_text'=>'<span class="button">上传(Max 30 MB)</span>',
        'button_text_style'=>'.button { font-family:"微软雅黑", sans-serif; font-size: 15px; text-align: center;color: #666666; }',
        'button_text_top_padding'=>0,
        'button_text_left_padding'=>0,
        'button_window_mode'=>'js:SWFUpload.WINDOW_MODE.TRANSPARENT',
        'button_cursor'=>'js:SWFUpload.CURSOR.HAND',
        ),
    )
);
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'userInfo-form',
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="errorMessage">
		<?php echo $form->errorSummary($model); ?>
	</div>

	<?php echo $form->labelEx($model,'用户id'); ?>
    <?php echo $form->textField($model,'user_id',array('class'=>'form-input-text')); ?>
    <br />
	 <div class="swfupload"><span id="swfupload">上传</span>(只可以上传1个文件,支持格式:png,jpg,jpeg,gif,zip,rar,pdf.)</div>

	 <?php echo CHtml::submitButton($model->isNewRecord ? '提交' : '保存修改',array('id'=>'reply','name'=>'submit','class'=>'form-button form-button-submit')); ?>

<?php $this->endWidget(); ?>

</div>