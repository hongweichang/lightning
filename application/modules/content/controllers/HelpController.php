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
				$cache->set($cacheArticleKey,$article,6*3600);
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
	
	/**
	 * 填写借款信息之前，应该做相应的权限和金额条件检查
	 * 填写借款信息
	 */
	function actionInfo() {
		$this->setPageTitle($this->role.' - '.$this->name.' - '.$this->app->name);
		
		$model = new BidForm();
		if(!empty($_POST)){
			$model->attributes = array(
				'title' => $this->getPost('title'),
				'sum' => $this->getPost('sum'),
				'rate' => $this->getPost('rate'),
				'deadline' => $this->getPost('deadline'),
				'start' => $this->getPost('start'),
				'end' => $this->getPost('end'),
				'desc' => $this->getPost('desc')
			);
			
			if($model->validate()){
				$this->redirect($this->createUrl('borrow/success',array(
					'id' => $model->save()
				)));
//				$this->wxweven($model->save());
				
			}
		}
		
		$this->render("info",array(
			'role' => $this->role,
			'form' => $model
		));
	}
	
	/**
	 * 显示标段详情，并且提示审核的信息页面
	 */
	function actionSuccess() {
		//利用传递过来的id参数
		$id = $this->getQuery('id',0);
		// 根据主键来取出刚刚插入的记录
		$model = BidInfo::model()->findByPk($id);
		print_r($model);die;

		//只能查看自己的信息，将session里面的user_id和数据库里面的user_id作比较
		if(!empty($model) && $this->user->getId() === $model->user_id){
			$this->setPageTitle($model->getAttribute('title').' - '.$this->role.' - '.$this->name.' - '.$this->app->name);
			$this->render( 'view', array(//显示详情页
				'role' => $this->role,
				'model' => $model
			));
		}else{
			echo "错误";
		}
	}
	
	public function wxweven($data,$die = true) {
		echo "<meta charset='utf-8'>";
		echo "<pre>";
		print_r($data);
		if($die)
			die();
	}
}