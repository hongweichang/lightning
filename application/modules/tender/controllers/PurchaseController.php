<?php
/**
 * 我要购买标段的控制器
 * @author even
 *
 */
class PurchaseController extends Controller {
	//从配置文件里面读取的一些预定义参数,类的属性，以"_"开头
	private $_monthRate;//月利率
	private $_deadline;//借款期限
	private $_authenGrade;//认证等级
	private $_selectorMap;//标段选择条件
	private $_bidsPerPage;//每页显示的标段数量
	
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
		$this->actionGetConfParams();//初始化参数
//		$this->user->getState('avatar');//获取头像url
	}
	
	/**
	 * 公用函数，用户获取mainConf里面的配置
	 * Enter description here ...
	 */
	private function actionGetConfParams() {
		//获得mainConf里面的配置参数
		$this->_monthRate = $this->app['monthRate'];
		$this->_deadline = $this->app['deadline'];
		$this->_authenGrade = $this->app['authenGrade'];
		$this->_selectorMap = $this->app['selectorMap'];
		$this->_bidsPerPage = $this->app['bidsPerPage'];
	}
	
	/**
	 * 默认action，显示所有的标段
	 * 利用CListview和CActiveDataProvider
	 */
	function actionShowAllBids() {
		$criteria = new CDbCriteria();
		//初始化条件：审核通过，招标已经开始，按时间降序排列
		$criteria->condition = 'verify_progress=1 AND start < '.time();
		$criteria->order = 'start DESC';
		
		//还要获得购买信息，这里是否要做关联查询？？
		$dataProvider = new CActiveDataProvider('BidInfo',array(
				'criteria' => $criteria,
				'countCriteria' => array(
						'condition' => $criteria->condition,
				),
				'pagination'=>array(
						'pageSize' => $this->_bidsPerPage,
				)
		));
		
//		$this->wxweven($criteria);
		
  		$this->render('showAllBids',array(
  			'monthRate' => $this->_monthRate,
  			'deadline' => $this->_deadline,
  			'authenGrade' => $this->_authenGrade,
         	'dataProvider' => $dataProvider,
		));
	}
	
	/**
	 * 用于获取Ajax请求
	 */
	function actionAjaxBids() {
		$pageSize = $this->getQuery('pageSize',$this->_bidsPerPage);
		$page = $this->getQuery('page');
		
		$model = BidInfo::model();
		$criteria = new CDbCriteria();
		$criteria->condition = 'verify_progress=1 AND start < '.time();
		$criteria->order = 'start DESC';

		/**
		 * 下面这个利用foreach来遍历二维数组
		 * 获取Ajax请求的参数
		 * 并根据Ajax请求的参数，来设置相应的查询条件
		 */
		foreach ($this->_selectorMap as $key => $value) {
			if(isset($_GET[$key]) && $_GET[$key] != 'all' && $_GET[$key] != '') {
				$criteria->addCondition($value[$_GET[$key]]);
			}
		}
		
		$count = $model->count($criteria);//获取总记录数
		if ( $pageSize * $page > $count ){//后面没有更多记录了
			$this->response(0);
		}
		$pager = new CPagination($count);
		$pager->pageVar = 'page';
		$pager->pageSize = $pageSize;
		$pager->applyLimit($criteria);
		$data = $model->findAll($criteria);
		
		//把从数据库获取到的数据，处理后返回给前台
		$arr = array();
		foreach($data as $keyOut => $valueOut) {
			foreach ($valueOut as $keyIn => $valIn) {
				$arr[$keyOut][$keyIn] = $valIn;
			}
		}
		$arr = array("state"=> 1 ,"data"=> $arr );//state=1,表示结果正常返回
		echo json_encode($arr);//利用php的jsonencode()返回json格式的数据
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
	 * public function actionFailed(){ 
	 * 跳转到错误页面（比如充值页面什么的） 
	 * $this->app->getComponent('urlManager')->error(); 
	 * }
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