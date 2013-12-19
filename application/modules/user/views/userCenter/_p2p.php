<?php
/**
 * file: _p2p.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-12-20
 * desc: 
 */
$p2p->pagination = false;
$this->widget('zii.widgets.CListView',array(
		'dataProvider' => $p2p,
		'itemView' => $view,
		'template' => '{items}',
		'itemsTagName' => 'tbody',
		'emptyText' => '',
		'ajaxUpdate' => false,
		'cssFile' => false,
		'baseScriptUrl' => null,
)); ?>