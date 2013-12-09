<?php
/**
 * 我要购买标段的控制器
 * @author even
 *
 */
class PurchaseController extends Controller {
	private $name = '我要投资';
	//从配置文件里面读取的一些预定义参数,类的属性，以"_"开头
	private $_monthRate;//月利率
	private $_deadline;//借款期限
	private $_authenGrade;//认证等级
	private $_selectorMap;//标段选择条件
	private $_bidsPerPage;//每页显示的标段数量

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
	
	public function init() {
		parent::init();

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
	function actionIndex() {
		$this->setPageTitle($this->name.' - '.$this->app->name);
		
		$pager = new CPagination(BidInfo::model()->count());
		$pager->setPageSize(10);
		
		$bidInfo = BidInfo::model()->with('user')->findAll(array(
			'offset' => $pager->getOffset(),
			'limit' => $pager->getLimit(),
			'condition' => "verify_progress=1 AND start<'".strtotime(date('Y-m-d'))."'",
			'order' => 'pub_time DESC'
		));
		
  		$this->render('index',array(
  			'monthRate' => $this->_monthRate,
  			'deadline' => $this->_deadline,
  			'authenGrade' => $this->_authenGrade,
         	'data' => new CArrayDataProvider($bidInfo),
		));
	}
	
	/**
	 * 购买标段的action
	 * Enter description here ...
	 * @param $bidId：标段id
	 * @param $userId：借款人的id
	 */
	function actionInfo() {
		$bid = BidInfo::model()->with('user','bidMeta')->findByPk($this->getQuery('id'));
		
		if(!empty($bid)){
			$this->setPageTitle($bid->getAttribute('title').' - '.$this->name.' - '.$this->app->name);
			
			$model = new MetaForm();
			if(!empty($_POST)){
				$model->attributes = array(
					'bid' => $bid->getAttribute('id'),
					'sum' => $this->getPost('sum'),
					'code' => $this->getPost('code'),
					'protocal' => $this->getPost('protocal')
				);
				
				if($model->validate()){
					$this->redirect($this->createUrl('platform/index',array(
						'meta_no' => $model->save()
					)));
				}
			}
			
			$bider = $bid->getRelated('user');
			$this->render("info",array(
				'bid' => $bid,
				'bider' => $bider,
				'form' => $model,
				'meta' => new CArrayDataProvider($bid->getRelated('bidMeta')),
				'user' => $this->app->getModule('user')->userManager->getUserInfo($this->user->getId()),
				'authGrade' => $this->app->getModule('credit')->getComponent('userCreditManager')->getUserCreditLevel($bider->getAttribute('id')),
			));
		}else{
			// 404
		}
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
}