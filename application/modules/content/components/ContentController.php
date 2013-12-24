<?php
/**
 * @name ContentController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-24 
 * Encoding UTF-8
 */
class ContentController extends Controller{
	/**
	 * 
	 * @var ContentManager
	 */
	public $content;
	/**
	 * 
	 * @var ArticleCategory
	 */
	public $activeCategory;
	/**
	 * 
	 * @var ArticleCategory[]
	 */
	public $categories;
	/**
	 * 
	 * @var int
	 */
	public $categoryId;
	
	public function init(){
		parent::init();
		$this->content = $this->getModule()->getComponent('contentManager');
	}
	
	public function getCategoryByFid($fid,$config=array(),$cacheTime=21600){//6*3600=21600
		$this->categoryId = $this->getQuery('cid',null);
		$cache = $this->app->cache;
		
		if ( $cache !== null ){
			$cacheCategoryKey = 'SITE_GET_HELPS_CATEGORY';
			$category = $cache->get($cacheCategoryKey);
			if ( $category === false ){
				$category = $this->content->getCategoryProviderViaType($config,$fid,false)->getData();
				$cache->set($cacheCategoryKey,$category,$cacheTime);
			}
		}else {
			$category = $this->content->getCategoryProviderViaType($config,$fid,false)->getData();
		}
		
		$this->activeCategory = $category[0];
		if ( $this->categoryId === null ){
			$this->categoryId = $this->activeCategory->id;
		}else {
			foreach ( $category as $cat ){
				if ( $cat->id == $cid ){
					$this->activeCategory = $cat;
					break;
				}
			}
		}
		
		return $this->categories = $category;
	}
}