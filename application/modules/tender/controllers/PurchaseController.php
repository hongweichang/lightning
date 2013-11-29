<?php
/**
 * 我要购买标段的控制器
 * @author even
 *
 */
class PurchaseController extends Controller {
	public $defaultAction = "showAllBids"; // 更改默认的action,默认显示所有的标段
	
	public function filters() {
		return '';
	}
	
	public function noneLoginRequired(){
		return '';
	}
	public function init() {
		parent::init();
		Yii::import( 'application.modules.tender.models.*' );
		Yii::import( 'application.modules.tender.components.*' );
//		$this->user->getState('avatar');//获取头像url
	}
	
	/**
	 * 默认action，显示所有的标段
	 * 利用CListview
	 */
	function actionShowAllBids() {
		//获得mainConf里面的配置参数
		$monthRate = $this->app['monthRate'];
		$deadline = $this->app['deadline'];
		$authenGrade = $this->app['authenGrade'];
		
		$criteria = new CDbCriteria();
		$criteria->condition = 'verify_progress=1 AND start < '.time();
		$criteria->order = 'start DESC';
//		$criteria->limit = '10';//初始条件显示两条
		
		$selectorMap = $this->app['selectorMap'];
		/**
		 * 下面这个利用foreach来遍历二维数组
		 * 获取Ajax请求的参数
		 * 并根据Ajax请求的参数，来设置相应的查询条件
		 */
		foreach ($selectorMap as $key => $value) {
			if(isset($_POST[$key]) && $_POST[$key] != 'all') {
				$criteria->addCondition($value[$_POST[$key]]);
			}
		}
//		$criteria->with = array('user');
		
		$dataProvider = new CActiveDataProvider('BidInfo',array(
				'criteria' => $criteria,
				'countCriteria' => array(
						'condition' => $criteria->condition,
				),
				'pagination'=>array(
						'pageSize' => 1
				)
		));
		
  		$this->render('showAllBids',array(
  			'monthRate' => $monthRate,
  			'deadline' => $deadline,
  			'authenGrade' => $authenGrade,
         	'dataProvider' => $dataProvider,
		));
	}
	
	/**
	 * 公用函数，用户获取mainConf里面的配置
	 * Enter description here ...
	 */
	function actionCommon() {
		//获得mainConf里面的配置参数
		$monthRate = $this->app['monthRate'];
		$deadline = $this->app['deadline'];
		$authenGrade = $this->app['authenGrade'];
		$selectorMap = $this->app['selectorMap'];
	}
	/**
	 * 用于获取Ajax请求
	 * Enter description here ...
	 */
	function actionAjaxBids() {
		$pageSize = $this->getQuery('pageSize',1);
		$page = $this->getQuery('page');
		$model = BidInfo::model();

		//获得mainConf里面的配置参数
		$monthRate = $this->app['monthRate'];
		$deadline = $this->app['deadline'];
		$authenGrade = $this->app['authenGrade'];
		
		$criteria = new CDbCriteria();
		$criteria->condition = 'verify_progress=1 AND start < '.time();
		
		$selectorMap = $this->app['selectorMap'];
		
		/**
		 * 下面这个利用foreach来遍历二维数组
		 * 获取Ajax请求的参数
		 * 并根据Ajax请求的参数，来设置相应的查询条件
		 */
		foreach ($selectorMap as $key => $value) {
			if(isset($_GET[$key]) && $_GET[$key] != 'all' && $_GET[$key] != '') {
				$criteria->addCondition($value[$_GET[$key]]);
			}
		}
		
		$count = $model->count($criteria);
		if ( $pageSize * $page > $count ){
			$this->response(0);
		}
		$pager = new CPagination($count);
		$pager->pageVar = 'page';
		$pager->pageSize = $pageSize;
		$pager->applyLimit($criteria);
		
		$data = $model->findAll($criteria);
		$arr = array();
		foreach($data as $keyOut => $valueOut) {
			foreach ($valueOut as $keyIn => $valIn) {
				$arr[$keyOut][$keyIn] = $valIn;
			}
		}
		$arr = array("state"=> 1 ,"data"=> $arr );
		echo json_encode($arr);
	}
	
	/**
	 * 显示标段详细信息
	 * @param $bidId:标段id
	 */
	function acrtionShowBidDetail($bidId) {
		$bidDetail = BidInfo::model(); // 标段信息对应的表
		                               
		// 调用其他组件接口，获得发标人的信息
//		$userInfo = $this->user->getUserInfo();
		$bidDetail = $model->findByPk( $bidId ); // 通过标段id来获取标段信息
		$info = array();
		$info ['bid'] = $bidDetail;
		$info ['user'] = $userInfo;
		// 显示标段的详细信息，包括发布标段的用户信息和标段本身的信息
		$this->render( 'bidDetail', array(
				'info' => $info 
		) );
	}
	
/**
	 * @return 返回标段的详细信息
	 * @param $bidId:标段id
	 */
	function acrtionGetBidDetail($bidId) {
		$bidDetail = BidInfo::model(); // 标段信息对应的表
		                               
		$bidDetail = $model->findByPk( $bidId ); // 通过标段id来获取标段信息
		return $bidDetail;//返回标段详细信息
	}
	
	/**
	 * 购买对应的标段action
	 * 
	 * @param
	 *        	$bidId:要购买的标段id
	 */
	function actionCreatePurchase($bidId) {
//		验证金额
		if($this->checkMoney()) {
//			验证身份，调用接口
			if(checkIdentity()) {
				$model = new BidMeta();//购买标段信息表
				
				if(isset($_POST['bidPurchase'])) {
					$_POST['buy_time'] = time();
					$model->attributes = $_POST['bidPurchase'];
					
					if($model->save()) {//将购买的信息插入数据库后，跳转到购买信息页
						$id = $model->getDbConnection()->getLastInsertID();
						$this->actionViewInfo( $id ); // 显示标段详情
					}
				}
			}
		}
	}
	
	/**
	 * 调用其他接口，判断该用户是否有足够金额来购买该标段
	 * 
	 * @param unknown $bidId        	
	 * @param unknown $userId        	
	 */
	function checkMoney($bidId, $userId, $mondy) {
		// 调研其他接口来判断
	}
	
	/*
	 * public function actionFailed(){ 跳转到错误页面（比如充值页面什么的） $this->app->getComponent('urlManager')->error(); }
	 */
	function actionViewInfo($id) {
		// 根据主键来取出刚刚插入的记录
		$model = BidIndo::model()->findByPk( $id );
		
		// 显示购买详情的页面
		$this->render( 'viewBidInfo', array('model' => $model) );
	}
	
	/**
	 * 购买成功的处理函数
	 */
	function actionSuccess() {
		/**
		 * 购买成功相应的处理
		 */
	}
	
	/**
	 * 购买失败的处理函数
	 */
	function actionFailure() {
		/**
		 * 失败处理功能：跳转到错误页面或者其他。。。
		 */
	}
	
	public function wxweven($data,$die = true) {
		echo "<meta charset='utf-8'>";
		echo "<pre>";
		print_r($data);
		if($die)
			die();
	}
	
}