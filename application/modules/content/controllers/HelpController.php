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
			$cacheArticleKey = 'SITE_GET_HELPS_ARTICLE_BY_CID_'.$this->categoryId;
			$article = $cache->get($cacheArticleKey);
			$article =false;
			if ( $article === false ){
				$article = $this->getModule()->getComponent('contentManager')->getArticleProviderViaCat(array(),$this->categoryId,false)->getData();
				$cache->set($cacheArticleKey,$article,600);
			}
		}else {
			$article = $this->getModule()->getComponent('contentManager')->getArticleProviderViaCat(array(),$this->categoryId,false)->getData();
		}
		
		$this->cs->registerScriptFile($this->scriptUrl.'help.js',CClientScript::POS_END);
		$this->render('index',array(
				'article' => $article,
		));
	}
}