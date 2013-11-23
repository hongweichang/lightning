<div>
	<?php $form=$this->beginWidget('CActiveForm')?>
	<div>
		<?php echo $form->lableEx($model,'标题'); ?>
		<?php echo $form->lableField($model,'title'); ?>
	</div>
	
	<div>
		<?php echo $form->lableEx($model,'借款描述'); ?>
		<?php echo $form->lableArea($model,'description',array('rows'=>5,'cols'=>60)); ?>
	</div>
	
	<div>
		<?php echo $form->lableEx($model,'借款金额'); ?>
		<?php echo $form->lableArea($model,'sum'); ?>
	</div>
	
	<div>
		<?php echo $form->lableEx($model,'月利率'); ?>
		<?php echo $form->lableArea($model,'month_rate'); ?>
	</div>
	
	<div>
		<!-- 用日期插件  -->
		<?php echo $form->lableEx($model,'开始日期'); ?>
		<?php echo $form->lableArea($model,'start'); ?>
	</div>
	
	<div>
		<!-- 用日期插件  -->
		<?php echo $form->lableEx($model,'结束日期'); ?>
		<?php echo $form->lableArea($model,'end'); ?>
	</div>
	
	<div>
		<!-- 用日期插件  -->
		<?php echo CHtml::submitButton('提交信息'); ?>
	</div>
	<?php $this->endWidget(); ?>
</div>