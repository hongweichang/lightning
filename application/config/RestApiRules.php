<?php
/*
**rest API配置
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/

return array(
		array(
				'pattern'=>'<_m:(user)>/<_a:(CreditGrade)>/<id:\d+>',
				'<_m>/service/get<_a>',
				'verb'=>'GET'
			),
	);
?>