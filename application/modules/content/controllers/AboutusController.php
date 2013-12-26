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
		$cache = $this->app->cache;
	
		$this->getCategoryByFid(2);
		if ( $cache !== null ){
			$cacheArticleKey = 'SITE_GET_ABOUTUS_BY_CID_'.$this->categoryId;
			$abouts = $cache->get($cacheArticleKey);
			if ( $abouts === false ){
				$abouts = $this->getModule()->getComponent('contentManager')->getArticleProviderViaCat(array(),$this->categoryId,false)->getData();
				$cache->set($cacheArticleKey,$abouts,600);
			}
		}else {
			$abouts = $this->getModule()->getComponent('contentManager')->getArticleProviderViaCat(array(),$this->categoryId,false)->getData();
		}

		$this->render('index',array(
				'article' => $abouts,
		));
	}
}