<?php
/**
 * Project OKBT
 * @name pager.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-4-20 
 * Encoding UTF-8
 */

?>

<?php
	if ( $pager->pageSize < $pager->itemCount ){
		$this->widget('LinkPager', array(
	    		'pages' => $pager,
			'htmlOptions' => array(
					'id' => 'page'
			),
			'header' => '',
			'cssFile' => false,
			'firstPageLabel' => null,
			'lastPageLabel' => null,
			'prevPageLabel' => '上一页',
			'nextPageLabel' => '下一页',
			'internalPageCssClass' => '',
			'selectedPageCssClass' => 'active',
			'previousPageCssClass' => 'page-prev',
			'nextPageCssClass' => 'page-next',
			'firstPageCssClass' => '',
			'lastPageCssClass' => '')
		);
	}else{
	}
?>