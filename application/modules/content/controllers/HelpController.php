<?php
/**
 * 我要借款的控制器
 * @author even
 */

class HelpController extends Controller {

	private $name = '帮助中心';
	
	public function init(){
		parent::init();
	}
	
	public function noneLoginRequired(){
		return 'index';
	}
	
	function actionIndex() {
		$this->setPageTitle($this->name);
		$cid = $this->getQuery('cid',null);
		$cache = $this->app->cache;
		
		if ( $cache !== null ){
			$cacheCategoryKey = 'SITE_GET_HELPS_CATEGORY';
			$category = $cache->get($cacheCategoryKey);
			if ( $category === false ){
				$category = $this->getModule()->getComponent('contentManager')->getCategoryProvider(array(),false)->getData();
				$cache->set($cacheCategoryKey,$category,6*3600);
			}
		}else {
			$category = $this->getModule()->getComponent('contentManager')->getCategoryProvider(array(),false)->getData();
		}
		
		$activeCategory = $category[0];
		if ( $cid === null ){
			$cid = $activeCategory->id;
		}else {
			foreach ( $category as $cat ){
				if ( $cat->id == $cid ){
					$activeCategory = $cat;
					break;
				}
			}
		}
		
		if ( $cache !== null ){
			$cacheArticleKey = 'SITE_GET_HELPS_ARTICLE_BY_CID'.$cid;
			$article = $cache->get($cacheArticleKey);
			if ( $article === false ){
				$article = $this->getModule()->getComponent('contentManager')->getArticleProvider(array(),1,$cid,false)->getData();
				$cache->set($cacheArticleKey,$article,60);
			}
		}else {
			$article = $this->getModule()->getComponent('contentManager')->getArticleProvider(array(),1,$cid,false)->getData();
		}
		
		$this->render("index",array(
			'category' => $category,
			'article' => $article,
			'activeCategory' => $activeCategory
		));
	}
}