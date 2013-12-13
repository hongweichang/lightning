<?php
/**
 * @name bannerFile.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-14 
 * Encoding UTF-8
 */
?>
<div class="bannerFile"><label>图片标题</label><?php echo $form->textField($model,'file_titles[]',array('class'=>'text-input small-input'));?><label>链接地址*</label><?php echo $form->textField($model,'redirect_urls[]',array('class'=>'text-input small-input'));?><label>图片文件*</label><?php echo $form->fileField($model,'files[]',array('class'=>'file'))?></div>