<?php
/**
 * 我要借款的控制器
 * @author even
 */

class HelpController extends ContentController {

	private $name = '帮助中心';
	
	public function init(){
		parent::init();
		$this->setPageTitle($this->name);
	}
	
	public function noneLoginRequired(){
		return 'index';
	}
	
	public function actionIndex(){
		$cache = $this->app->cache;
		
		$this->getCategoryByFid(1);
		if ( $cache !== null ){
			$cacheArticleKey = 'SITE_GET_HELPS_ARTICLE_BY_CID'.$this->categoryId;
			$article = $cache->get($cacheArticleKey);
			if ( $article === false ){
				$article = $this->getModule()->getComponent('contentManager')->getArticleProviderViaType(array(),1,false)->getData();
				$cache->set($cacheArticleKey,$article,600);
			}
		}else {
			$article = $this->getModule()->getComponent('contentManager')->getArticleProviderViaType(array(),1,false)->getData();
		}
		
		$this->render('index',array(
				'article' => $article,
		));
	}
}