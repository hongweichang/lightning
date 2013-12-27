<?php
/*
**rest API配置
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/

return array(
		array(
				'pattern'=>'<_m:(appservice)>/<_a:(CreditGrade|Balance|UserCredit)>/',
				'<_m>/appUser/get<_a>',
				'verb'=>'POST'
			),

		array(
				'pattern'=>'<_m:(user)>/<_a:(UserMessage)>',
				'<_m>/service/create<_a>',
				'verb'=>'POST'
			),

		array(
				'pattern'=>'<_m:(appservice)>/<_a:(login|logout|register|registerVerifyCode)>',
				'<_m>/appUser/<_a>',
				'verb'=>'POST'
			),

		array(
				'pattern'=>'<_m:(appservice)>/<_a:(BidList|BidById|BidListById|MetaList)>',
				'<_m>/appTender/get<_a>',
				'verb'=>'post'
			),

		array(
				'pattern'=>'<_m:(appservice)>/<_a:(raiseBid|purchaseBid)>',
				'<_m>/appTender/<_a>',
				'verb'=>'post'
			),

		array(
				'pattern'=>'<_m:(appservice)>/<_a:(payPurchasedBid)>',
				'<_m>/AppPay/<_a>',
				'verb'=>'post'
			),

		array(
				'pattern'=>'<_m:(appservice)>/<_a:(userMessage|userIcon)>',
				'<_m>/appUser/create<_a>',
				'verb'=>'POST'

			),
		array(
				'pattern'=>'<_m:(appservice)>/<_a:(getBanner)>',
				'<_m>/appContent/<_a>',
			)

	);
?>