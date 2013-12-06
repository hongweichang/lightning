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
	
	public function actions(){
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
				'maxLength' => 4,
				'minLength' => 4
			),
		);
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
		$criteria->with = 'bidMeta';//调用relations   
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
		
  		$this->render('showAllBids',array(
  			'monthRate' => $this->_monthRate,
  			'deadline' => $this->_deadline,
  			'authenGrade' => $this->_authenGrade,
         	'dataProvider' => $dataProvider,
  			'purchaseUrl' => 'purchase/purchaseBid/',
		));
	}
	
	/**
	 * 用于获取Ajax请求
	 */
	function actionAjaxBids() {
		$pageSize = (int)$this->getQuery('pageSize',$this->_bidsPerPage);
		$page = (int)$this->getQuery('page');
		
		$model = BidInfo::model();
		$criteria = new CDbCriteria();
		$criteria->condition = 'verify_progress=1 AND start < '.time();
		$criteria->order = 'start DESC';
		$criteria->with = 'bidMeta';

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
		//有viewmore参数的请求时点击查看更多发起的ajax请求
		if(isset($_GET['viewmore']) && $_GET['viewmore'] == 1) {
			$totalPages = ceil($count / $pageSize);//获得总页数
			if (  $page > $totalPages ){//当前页大于总页数，就没有更多了	
				$this->response(0);
			}
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
				//拼接购买该标段的链接
				$arr[$keyOut]['titleHref'] = "purchase/purchaseBid/bidId/".$valueOut['id']."/userId/".$valueOut['user_id'];
				$arr[$keyOut]['authGrade'] = $this->getUserAuthGrade($valueOut['user_id']);//得到用户的认证等级
			}
		}
		
		$arr = array("state"=> 1 ,"data"=> $arr );//state=1,表示结果正常返回
		echo json_encode($arr);//利用php的jsonencode()返回json格式的数据
	}
	
	/**
	 * 购买标段的action
	 * Enter description here ...
	 * @param $bidId：标段id
	 * @param $userId：借款人的id
	 */
	function actionPurchaseBid() {
		$bidId = $this->getQuery('bidId',null);//标段id
		$userId = $this->getQuery('userId',null);//发标人id
		
		$bidInfo = $this->getBidDetail($bidId,true);
		//这里的userId是发标用户的id，而不是当前登录用户的id
		//当前登录用户的id是：$this->user->getId()
		$authGrade = $this->getUserAuthGrade($userId);//得到发标人的认证等级
		$borrowUserInfo = $this->getUserInfo($userId);//得到发布标段的人的信息
		$currentUserInfo = $this->getUserInfo($this->user->getId());//得到当前登录用户的信息
		
		$this->render("purchaseBid",array(
				'bidInfo' => $bidInfo,
				'borrowUserInfo' => $borrowUserInfo,
				'currentUserInfo' => $currentUserInfo,
				'authGrade' => $authGrade,
				'formAction' => 'purchase/purchaseBidToDb',
		));
	}
	
	/**
	 * 将购买的标段信息插入数据库
	 * Enter description here ...
	 */
	function actionPurchaseBidToDb() {
		//利用传递过来的参数
		$bidId = $this->getQuery('bidId',null);//要购买的标段的id
		$userId = $this->getQuery('userId',null);//购买人，即当前用户的id
		$code = $_POST['writeBidMeta']['code'];
		if($_SESSION['Yii.CCaptchaAction.Powered By XCms.tender/purchase.captcha'] != $code){
			$this->redirect($this->createUrl('purchase/purchaseBid',array(
				'bidId' => $bidId,
				'userId' => $userId
			)));
		}
		/*
		$model = new BidMeta();	//购买标段对应的表
		
		$_POST['writeBidMeta']['user_id'] = $userId;
		$_POST['writeBidMeta']['bid_id'] = $bidId;
		$_POST['writeBidMeta']['buy_time'] = time();
		
		$model->attributes = $_POST['writeBidMeta'];//利用表单来填充
		*/
		$meta_id = $this->getModule()->bidManager->purchaseBid($this->user->getId(),$bidId,$_POST['writeBidMeta']['sum']);
		if($meta_id != 0){//如果插入数据库成功
			/**
			 * 插入数据库后 ，跳转到付款界面，调用接口
			 */
			//Yii::app()->getModule('pay')->fundManager->pay($meta_id);
//			Yii::app()->redirect('pay/platform/index',array('no'=>$meta_id));
			$this->redirect($this->createUrl('platform/index',array('meta_no' => $meta_id)));
			
			/**
			 * 付款成功后:
			 * （1）将bid_meta表的status改为1
			 * （2）同时更新bid表的招标进度:progress = progress + (lend_sum/sum*100)
			 */
		}
	}
	
	/**
	 * 根据bidId得到标段详细信息
	 * @param $bidId:标段id
	 */
	private function getBidDetail($bidId,$related = false) {
		$model = BidInfo::model(); // 标段信息对应的表
		if($related === true)
			$bidDetail = $model->with('bidMeta')->findByPk( $bidId ); // 通过标段id来获取标段信息,同时做关联查询
		else//不做关联查询
			$bidDetail = $model->findByPk( $bidId );
		
		return $bidDetail;
	}
	
	/**
	 * 根据userId得到用户认证等级
	 * @param $userId:用户id
	 */
	private function getUserAuthGrade($userId) {
		$authGrade = Yii::app()->getModule('credit')->getComponent('userCreditManager')->getUserCreditLevel($userId);
		if($authGrade != "")
			return $authGrade;//返回用户认证等级
		else
			return "信用等级未知";
	}
	
	/**
	 * 根据userId得到详细信息
	 * @param $userId:用户id
	 */
	private function getUserInfo($userId) {
		$userInfo = Yii::app()->getModule('user')->userManager->getUserInfo($userId);
		return $userInfo;//返回用户信息数组
	}
	
	public function wxweven($data,$die = true) {
		echo "<meta charset='utf-8'>";
		echo time();
		echo "<pre>";
		print_r($data);
		if($die)
			die();
	}
	
}