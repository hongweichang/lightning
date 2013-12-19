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
	private $StartTime = 0; 
	private $StopTime = 0;
	

//	public $defaultAction = "showAllBids"; // 更改默认的action,默认显示所有的标段


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
	 * 用于获取Ajax请求来对标段列表进行筛选
	 * 购买标段的action
	 * Enter description here ...
	 * @param $bidId：标段id
	 * @param $userId：借款人的id
	 */
	function actionInfo() {
		$bid = BidInfo::model()->with('user','bidMeta')->findByPk($this->getQuery('id'));
		
		if(!empty($bid)){
			$this->setPageTitle($bid->getAttribute('title').' - '.$this->name);
			
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
			$return[$key]['month_rate'] /= 100;
			$return[$key]['sum'] = number_format($return[$key]['sum'],2).'元';
			$return[$key]['titleHref'] = $this->createUrl('purchase/info', array('id' => $value->getAttribute('id')));
			$return[$key]['authGrade'] = Yii::app()->getModule('credit')->getComponent('userCreditManager')->getUserCreditLevel($value->getAttribute('user_id'));
		}
		
		$return = array("state"=> 1 ,"data"=> $return );//state=1,表示结果正常返回
		echo CJSON::encode($return);//利用php的jsonencode()返回json格式的数据
	}

	/**
	 * 购买标段的action
	 * @param $bidId：标段id
	 * @param $userId：借款人的id
	 */
	function actionPurchaseBid() {
		$bidId = $this->getQuery('bidId',null);//标段id
		$userId = $this->getQuery('userId',null);//发标人id
		
		$bidInfo = $this->getBidDetail($bidId,true);//关联查询
		if(!$bidInfo)
			$bidInfo = $this->getBidDetail($bidId);//关联查询没有数据，就不作关联查询
			
		//这里的userId是发标用户的id，而不是当前登录用户的id
		//当前登录用户的id是：$this->user->getId()
		$authGrade = $this->getUserAuthGrade($userId);//得到发标人的认证等级
		$borrowUserInfo = $this->getUserInfo($userId);//得到发布标段的人的信息
		
		if(!array_key_exists($borrowUserInfo['role'],$this->app['roleMap'])) {
			//如果用户还没有填写角色，那么他的角色就不在预设定的角色数组里面，此时设置他的角色为unknown
			$borrowUserInfo['role'] = $this->app['roleMap']['unknown'];
		} else {
			$borrowUserInfo['role'] = $this->app['roleMap'][$borrowUserInfo['role']];
		}
		
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
	 * 购买标段的Ajax请求
	 */
	function actionPurchaseBidAjax() {
		$bidId = $this->getQuery('bidId',null);//标段id
		$lendNum = $this->getQuery('lendNum');//投资金额
		
		if(is_numric($lendNum)) {//判断输入的金额是不是数字
			$lendNum = (int) $lendNum;
		} else {
			$errMsg = '请输入正确的数字金额';
		}
		
		$bidInfo = $this->getBidDetail($bidId);
		//从数据库里面取出来的金额要除以100
		$leftMoney = ($bidInfo->sum / 100) * ( 1 - ($bidInfo->progress / 100));//剩余的投标金额
		
		
		if($lendNum <= 0 || $lendNum > $leftMoney) {//投资的金额不对
			$errMsg = "错误金额,请输入 0——".$leftMoney." 之间的金额";
		} else {
			/**
			 * 返回到期总收益和标段利率，这里的标段利率是买标人的利率，而不是发表人发布的利率（存在中间差价）
			 */
			$arr = array();
			$arr['bidRate'] = '10';//买标人的利率
			$arr['totalProfit'] = $lendNum * $bidInfo->deadline * $arr['bidRate'];
			
			$arr = array("state"=> 1 ,"data"=> $arr );//state=1,表示结果正常返回
			echo json_encode($arr);//利用php的jsonencode()返回json格式的数据
		}
	}
	
	/**
	 * 将购买的标段信息插入数据库
	 * Enter description here ...
	 */
	function actionPurchaseBidToDb() {
		//利用传递过来的参数
		$bidId = $this->getQuery('bidId',null);//要购买的标段的id
		$userId = $this->getQuery('userId',null);//购买人，即当前用户的id
		$code = $_POST['writeBidMeta']['code'];//验证码
		$sum = (int)trim($_POST['writeBidMeta']['sum']);
		
		if($_SESSION['Yii.CCaptchaAction.Powered By XCms.tender/purchase.captcha'] != $code){
			$this->redirect($this->createUrl('purchase/purchaseBid',array(
				'bidId' => $bidId,
				'userId' => $userId
			)));
		}
		
		//调用接口，将买标信息插入数据库，返回插入记录的id
		$meta_id = $this->getModule()->bidManager->purchaseBid($this->user->getId(),$bidId,$sum);
		if($meta_id != 0){//如果插入数据库成功
			/**
			 * 插入数据库后 ，跳转到付款界面，调用接口
			 */
//			Yii::app()->getModule('pay')->fundManager->pay($meta_id);
//			Yii::app()->redirect('pay/platform/index',array('no'=>$meta_id));
			$this->redirect($this->createUrl('platform/index',array('meta_no' => $meta_id)));
		}
	}
	
	/**
	 * 根据bidId得到标段详细信息
	 * @param $bidId:标段id
	 */
	private function getBidDetail($bidId,$related = false) {
		$model = BidInfo::model(); // 标段信息对应的表
		if($related === true) {
			//条件:付款完成 status=1，完成时间降序
			//这里需要注意的是，如果with关联的数据没有的话，则$bidDetail也会是null
			$bidDetail = $model->with(array(
					'bidMeta'=>array(
							'condition' => 'status=1',
							'order' => 'finish_time desc',
					)
			))->findByPk( $bidId ); // 通过标段id来获取标段信息,同时做关联查询
		}
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
 
    function get_microtime() 
    { 
        list($usec, $sec) = explode(' ', microtime()); 
        return ((float)$usec + (float)$sec); 
    } 
 
    function start() 
    { 
        $this->StartTime = $this->get_microtime(); 
    } 
 
    function stop() 
    { 
        $this->StopTime = $this->get_microtime(); 
    } 
 
    function spent() 
    { 
        return round(($this->StopTime - $this->StartTime) * 1000, 1); 
    } 
}