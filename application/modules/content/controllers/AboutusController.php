<?php
/**
 * @name AboutusController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-24 
 * Encoding UTF-8
 */
class AboutusController extends ContentController{
	public $name = '关于我们';
	
	public function noneLoginRequired(){
		return 'index';
	}
	
	public function actionIndex(){
		$this->setPageTitle($this->name);
		$cache = $this->app->cache;
		
		$categories = $this->getCategoryByFid(2);
		if ( $cache !== null ){
			$cacheKey = 'SITE_GET_ABOUTUS_BY_CID_'.$this->categoryId;
			$aboutus = $cache->get($cacheKey);
			if ( $aboutus === false ){
				$aboutus = $this->content->getArticleProvider(array(),2,$cid,false)->getData();
				$cache->set($cacheKey,$aboutus,60);
			}
		}
	}
}