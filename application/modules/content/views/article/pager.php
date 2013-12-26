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
			'header' => '',
			'cssFile' => false,
			'firstPageLabel' => '首页',
			'lastPageLabel' => '末页',
			'prevPageLabel' => '上一页',
			'nextPageLabel' => '下一页',
			'internalPageCssClass' => 'page-button',
			'selectedPageCssClass' => 'current page-button',
			'previousPageCssClass' => 'previous page-button',
			'nextPageCssClass' => 'next page-button',
			'firstPageCssClass' => 'previous page-button',
			'lastPageCssClass' => 'next page-button')
		);
	}else{
	}
?>