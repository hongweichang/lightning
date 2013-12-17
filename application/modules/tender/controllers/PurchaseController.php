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
	private $_bidsPerPage;

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
		
		$pager = new CPagination(BidInfo::model()->count("verify_progress=1 AND start<='".strtotime(date('Y-m-d'))."'"));
		$pager->setPageSize($this->_bidsPerPage);
		
		$bidInfo = BidInfo::model()->with('user')->findAll(array(
			'offset' => $pager->getOffset(),
			'limit' => $pager->getLimit(),
			'condition' => "verify_progress=1 AND start<='".strtotime(date('Y-m-d'))."'",
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
		$bid = BidInfo::model()->with('user')->findByPk($this->getQuery('id'));
		
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
					if(($meta_no = $model->save()) !== false){
						$this->redirect($this->createUrl('platform/order',array(
							'meta_no' => $meta_no
						)));
					}else{
						 // 已满标
					}
				}
			}
			
			$meta = BidMeta::model()->with('user')->findAll(array(
				'order' => 'buy_time DESC',
				'condition' => 'bid_id='.$bid->getAttribute('id')
			));
			
			$progress = BidMeta::model()->find(array(
				'select' => 'SUM(sum) AS sum',
				'condition' => 'bid_id='.$bid->getAttribute('id')
			));
			
			$bider = $bid->getRelated('user');
			$this->render("info",array(
				'bid' => $bid,
				'bider' => $bider,
				'progress' => $progress->getAttribute('sum') / 100,
				'form' => $model,
				'meta' => new CArrayDataProvider($meta),
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
		/**
		 * 下面这个利用foreach来遍历二维数组
		 * 获取Ajax请求的参数
		 * 并根据Ajax请求的参数，来设置相应的查询条件
		 */
		$criteria = new CDbCriteria();
		$criteria->addCondition('verify_progress=1');
		$criteria->addCondition('start<='.strtotime(date('Y-m-d')));
		$criteria->order = 'pub_time DESC';
		$criteria->with = 'user';
		
		foreach ($this->_selectorMap as $key => $value) {
			if(isset($_GET[$key]) && $_GET[$key] != 'all' && $_GET[$key] != '') {
				$criteria->addCondition($value[$_GET[$key]]);
			}
		}
		
		$pager = new CPagination(BidInfo::model()->count($criteria));
		$pager->validateCurrentPage = false;
		$pager->setPageSize($this->_bidsPerPage);
		//$pager->setCurrentPage($this->getQuery('page',1));
		$pager->applyLimit($criteria);
		$data = BidInfo::model()->findAll($criteria);
		
		//把从数据库获取到的数据，处理后返回给前台
		$return = array();
		foreach($data as $key => $value) {
			$return[$key] = $value->getAttributes();
			$return[$key]['titleHref'] = $this->createUrl('purchase/info', array('id' => $value->getAttribute('id')));
			$return[$key]['authGrade'] = Yii::app()->getModule('credit')->getComponent('userCreditManager')->getUserCreditLevel($value->getAttribute('user_id'));
		}
		
		$return = array("state"=> 1 ,"data"=> $return );//state=1,表示结果正常返回
		echo CJSON::encode($return);//利用php的jsonencode()返回json格式的数据
	}
}