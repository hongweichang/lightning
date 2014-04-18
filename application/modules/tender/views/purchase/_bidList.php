<?php
/**
 * file: _bidList.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-9
 * desc: 
 */
$userManager = $this->app->getModule('user')->userManager;
$bidProgressCssClassMap = $this->app['bidProgressCssClassMap'];
$progressClass = '';
foreach ( $bidProgressCssClassMap as $key => $bidProgressCssClass ){
	if ( ($data->getAttribute('progress')/100) <= $key ){
		$progressClass = $bidProgressCssClass;
	}
}
?>
<li class="loan-list">
	<div class="loan-avatar">
		<img src="<?php echo $userManager->getUserIcon($data->user_id)?>" />
		<span>信</span>
	</div>
	<div class="loan-title">
		<a href="<?php echo $this->createUrl('purchase/info', array('id' => $data->getAttribute('id')));?>">
        	<?php echo $data->getAttribute('title');?>
        </a>
	</div>
	<div class="loan-rate loan-num"><span class="val"><?php echo $data->getAttribute('month_rate') / 100;?></span>%</div>
	<div class="loan-rank">
		<?php																								
			$rank = Yii::app()->getModule('credit')->getComponent('userCreditManager')->getUserCreditLevel($data->getAttribute('user_id'));
		?>
		<div class="rank<?php echo $rank;?>"><?php echo $rank;?></div>
	</div>
	<div class="loan-amount loan-num"><span class="val">￥<?php echo number_format($data->getAttribute('sum') / 100,2);?></span>元</div>
	<div class="loan-time loan-num"><span class="val"><?php echo $data->getAttribute('deadline');?></span>个月</div>
	<div class="loan-progress">
		<div class="bar-out">
			<div class="bar-in">
				<span class="bar-complete <?php echo $progressClass; ?>" style="width:<?php echo $data->getAttribute('progress') / 100;?>%"></span>
				<span class="bar-num"><?php echo $data->getAttribute('progress') / 100;?>%</span>
			</div>
		</div>
	</div>
	<?php if ( $data->getAttribute('verify_progress') == 21 ):?>
	<a href="<?php echo $this->createUrl('purchase/info', array('id' => $data->getAttribute('id')));?>" class="invest">投标</a>
	<?php elseif ( $data->getAttribute('verify_progress') == 31 ):?>
	<a href="javascript:void(0);" class="invest off">还款中</a>
	<?php elseif ( $data->getAttribute('verify_progress') == 41 ):?>
	<a href="javascript:void(0);" class="invest compelete">已完成</a>
	<?php endif;?>
</li>
