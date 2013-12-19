<?php
/**
 * file: newfile.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-20
 * desc: 
 */
?>
<div style="float:left;">
	<p>客户资金总额：<?php echo number_format($sum,2); ?></p>
	<p>网站盈利总额</p>
</div>
<div style="float:left;margin-left:100px;">
	流动资金：
	<p>充值总额：<?php echo number_format($recharge,2); ?></p>
	<p>提现总额：<?php echo number_format($withdraw,2); ?></p>
	<p>平台收入总额</p>
	<p>第三方扣费总额总额</p>
</div>
<div style="float:left;margin-left:100px;">
	借款统计：
	<p>暂未审核通过标段总额：<?php echo number_format($view,2); ?></p>
	<p>正在招标标段总额：<?php echo number_format($biding,2); ?></p>
	<p>已完成标段总额：<?php echo number_format($done,2); ?></p>
	<p>已还款资金总额：<?php echo number_format($repaying,2); ?></p>
	<p>未还款资金总额</p>
	<p>流标资金总额：<?php echo number_format($lose,2); ?></p>
</div>

<div style="clear: both"></div>