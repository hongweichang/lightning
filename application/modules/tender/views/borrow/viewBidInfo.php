<div>
	<?php $form=$this->beginWidget('CActiveForm')?>
	<div>
		<?php echo '标题'; ?>
		<?php echo $model->title; ?>
	</div>
	
	<div>
		<?php echo '借款描述'; ?>
		<?php echo $model->description; ?>
	</div>
	
	<div>
		<?php echo '借款金额'; ?>
		<?php echo $model->sum; ?>
	</div>
	
	<div>
		<?php echo '月利率'; ?>
		<?php echo $model->month_rate; ?>
	</div>
	
	<div>
		<?php echo '开始日期'; ?>
		<?php echo $model->start; ?>
	</div>
	
	<div>
		<?php echo '开始日期'; ?>
		<?php echo $model->end; ?>
	</div>
	
	<?php $this->endWidget(); ?>
</div>