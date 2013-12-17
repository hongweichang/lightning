<?php
/**
 * @name SiteController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-24 
 * Encoding UTF-8
 */
class SiteController extends Controller{
	public function noneLoginRequired(){
		return 'index,test';
	}
	
	public function actionIndex(){
		$content = $this->app->getModule('content')->getComponent('contentManager');
		$cache = $this->app->cache;
		
		Yii::beginProfile('banner');
		$banner = $cache->get('SITE_BANNER');
		if ( $banner === false ){
			$banner = $content->getInUsingBanner(0);
			$cache->set('SITE_BANNER',$banner,24*3600);                                                                           
		}
		Yii::endProfile('banner');
		
		Yii::beginProfile('articles');
		$articles = $cache->get('INDEX_ARTICLES');
		if ( $articles === false ){
			$articlesProvider = $content->getArticleProvider(array(
					'criteria' => array(
							'order' => 'add_time DESC',
							'limit' => 5,
							'offset' => 0
					)
			),0);
			$articles = $articlesProvider->getData();
			foreach ( $articles as $i => $article ){
				$articles[$i]->content = preg_replace('/(.*)<.*>(.*)/iU','$1$2',$article->content);
			}
			$cache->set('INDEX_ARTICLES',$articles,6*3600);
		}
		Yii::endProfile('articles');
		
		Yii::beginProfile('bids');
		$bidData = $cache->get('INDEX_BIDS');
		if ( empty($bidData) ){
			$bidManager = $this->app->getModule('tender')->getComponent('bidManager');
			$bids = $bidManager->getBidList(array(
					'condition' => 'verify_progress=1 AND start<=:start',
					'limit' => 5,
					'offset' => 0,
					'order' => 'pub_time DESC',
					'params' => array(':start'=>time()),
					'with' => array(
							'user' => array(
									'with' => array(
											'icons' => array(
													'condition' => 'in_using=1'
											)
									)
							),
					)
			));
			$bidData = array();
			$userManager = $this->app->getModule('user')->getComponent('userManager');
			$userCreditManager = $this->app->getModule('credit')->getComponent('userCreditManager');
			foreach ( $bids as $bid ){
				$uid = $bid->user_id;
				$icons = $bid->user->icons;
				$iconName = empty($icons) ? null : $icons[0]->file_name;
				$icon = $userManager->resolveIconUrl($iconName,$iconName === null ? null : $uid);
				$rank = $userCreditManager->UserLevelCaculator($uid);
				
				$bidData[] = array(
						'id' => $bid->id,
						'userId' => $uid,
						'userIcon' => $icon,
						'title' => $bid->title,
						'monthRate' => ($bid->month_rate / 100).'%',
						'rank' => $rank,
						'sum' => '￥'.number_format($bid->sum / 100,2).'元',
						'deadline' => $bid->deadline.'个月',
						'progress' => $bid->progress.'%'
				);
			}
			$cache->set('INDEX_BIDS',$bidData,300);
		}
		Yii::endProfile('bids');
		
		Yii::beginProfile('render');
		$this->cs->registerCssFile($this->cssUrl.'index.css');
		$this->cs->registerScriptFile($this->scriptUrl.'slide_fade.js',CClientScript::POS_END);
		$this->render('index',array('banner'=>$banner,'articles'=>&$articles,'bids'=>$bidData));
		Yii::endProfile('render');
	}
	
	public function actionTest(){
		//var_dump($this->app->getEventHandlers('onEndRequest'));
		$async = $this->app->getComponent('asyncEventRunner');
		$async->raiseAsyncEvent('onRegisterSuccess',array('data'=>'sasa'));
	}
}