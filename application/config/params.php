<?php
/**
 * @name params.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-28 
 * Encoding UTF-8
 */
return array(
		'copyright' => '<p>重庆闪电贷金融信息服务有限公司 版权所有 2007-2013<p><p>Copyright Reserved 2007-2013&copy;闪电贷（www.shanddai.com） | 渝ICP备13008004号</p>',
		'phone' => '023-63080933',
		'asyncEvent' => array(),
		'roleMap' =>array(
				'gxjc' => '工薪阶层',
				'qyz' => '企业主',
				'wddz' => '网店店主',
				'unknown' => '还未填写角色',
		),
		'commonUrls' =>array(
				'index' => '/site',
				'useHelp' => '#',
		),
		'bidsPerPage' => 10,//默认的每次请求的标段条数
		
		//标段选择条件参数
		'selectorMap' => array(
				'monthRate' => array(//月利率条件
						'不限' => 'all',
						'5%-10%' => ' month_rate BETWEEN 500 AND 1000 ',
						'11%-15%' => ' month_rate BETWEEN 1100 AND 1500 ',
						'16%-20%' => ' month_rate BETWEEN 1600 AND 2000 ',
				),
				'deadline' => array(//借款期限条件
						'不限' => 'all',
						'6-12' => ' deadline BETWEEN 6 AND 12 ',
						'12-24' => ' deadline BETWEEN 12 AND 24 ',
						'24-36' => ' deadline BETWEEN 24 AND 36 ',
				),
				'authenGrade' => array(//认证等级条件
						'不限' => 'credit_grade >= 0',
						'AAA' => ' credit_grade >= 160 ',
						'AA' => ' credit_grade >= 120 AND credit_grade < 160 ',
						'A' => ' credit_grade >= 90 AND credit_grade < 120 ',
						'B' => ' credit_grade >= 70 AND credit_grade < 90 ',
						'C' => ' credit_grade >= 60 AND credit_grade < 70 ',
				),
		),
		'bidProgressCssClassMap' => array(
				'100' => 'w100',
				'99' => 'w80_99',
				'79' => 'w50_79',
				'49' => 'w0_49'
		),
);