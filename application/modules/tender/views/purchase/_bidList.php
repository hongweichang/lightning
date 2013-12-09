<?php
/**
 * file: _bidList.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-9
 * desc: 
 */
?>
<li class="loan-list">
	<div class="loan-avatar">
		<img src="<?php echo $this->imageUrl;?>intro-pic_1.png" />
		<span>信</span>
	</div>
	<div class="loan-title">
		<a href="<?php echo $this->createUrl('purchase/info', array('id' => $data['id']));?>">
        	<?php echo $data['title'];?>
        </a>
	</div>
	<div class="loan-rate loan-num"><?php echo $data['month_rate'];?>%</div>
	<div class="loan-rank">
		<?php																								
			$rank = Yii::app()->getModule('credit')->getComponent('userCreditManager')->getUserCreditLevel($data ['user_id']);
		?>
		<div class="rank<?php echo $rank;?>"><?php echo $rank;?></div>
	</div>
	<div class="loan-amount loan-num">￥<?php echo $data['sum'];?>元</div>
	<div class="loan-time loan-num"><?php echo $data['deadline'];?>个月</div>
	<div class="loan-progress">
		<div class="bar-out">
			<div class="bar-in">
				<span class="bar-complete" style="width:<?php echo $data['progress'];?>%"></span>
				<span class="bar-num"><?php echo $data['progress'];?>%</span>
			</div>
		</div>
	</div>
</li>
