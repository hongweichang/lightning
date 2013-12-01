<?php
/**
 * @author even
 * 利用Ajax来显示所有的标段信息
 */

	$this->widget('zii.widgets.CListView', array(
  		'dataProvider'=>$dataProvider,
  		'itemView'=>'_comments',// refers to the partial view named '_comments'
		'sortableAttributes'=>array(
	        'title',
	        'create_time'=>'Post Time',
	    ),
		//'ajaxUpdate'=> false,//这样就不会AJAX翻页
		
  		'pager' => array(//pager 的配置信息。默认为<code>array('class'=>'CLinkPager')</code>.也可以自己配置
   		'nextPageLabel' => '下一页 »',
   		'prevPageLabel' => '« 上一页'
   ),
   //在这里还可以配置一些排序规则，具体可以查阅手册
   ));