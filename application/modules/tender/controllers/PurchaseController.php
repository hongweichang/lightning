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
	
	public function noneLoginRequired(){
		return 'index,ajaxBids,info,captcha';
	}

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

		$this->_selectorMap = $this->app['selectorMap'];
		$this->_monthRate = $this->_selectorMap['monthRate'];
		$this->_deadline = $this->_selectorMap['deadline'];
		//$this->_authenGrade = $this->_selectorMap['authenGrade'];
		$this->_bidsPerPage = $this->app['bidsPerPage'];
	}
	
	public function loadCreditSettings(){
		$cache = $this->app->cache;
		$cackeKey = 'FRONT_CREDIT_SETTING_';
		$credit = $this->app->getModule('credit');
		
		$creditSettings = $cache->get($cackeKey);
		if ( $creditSettings === false ){
			$credit = $credit->getComponent('userCreditManager');
			$creditSettings = $credit->UserLevelList();
			$cache->set($cackeKey,$creditSettings,600);
		}
		
		$this->_authenGrade['不限'] = 'credit_grade >= 0';
		for ( $i=0; isset($creditSettings[$i]); ++$i ){
			if ( $creditSettings[$i]->start <= 0 ){
				continue;
			}
			if ( isset($creditSettings[$i+1]) && $creditSettings[$i+1]->start > 0 ){
				$this->_authenGrade[$creditSettings[$i]->label] = 'credit_grade BETWEEN '.$creditSettings[$i]->start.' AND '.$creditSettings[$i+1]->start;
			}else {
				$this->_authenGrade[$creditSettings[$i]->label] = 'credit_grade>='.$creditSettings[$i]->start;
			}
		}
		$this->_selectorMap['authenGrade'] = $this->_authenGrade;
	}
	
	/**
	 * 默认action，显示所有的标段
	 * 利用CListview和CActiveDataProvider
	 */
	function actionIndex() {
		$this->setPageTitle($this->name);
		
		$this->loadCreditSettings();
		$condition = "verify_progress=21 AND start<=".time();
		$pager = new CPagination(BidInfo::model()->count($condition));
		$pager->setPageSize($this->_bidsPerPage);
		$pager->route = 'purchase/ajaxBids';
		
		$bidInfo = BidInfo::model()->with('user')->findAll(array(
			'offset' => $pager->getOffset(),
			'limit' => $pager->getLimit(),
			'condition' => $condition,
			'order' => 'pub_time DESC'
		));
		
  		$this->render('index',array(
  			'monthRate' => $this->_monthRate,
  			'deadline' => $this->_deadline,
  			'authenGrade' => $this->_authenGrade,
         		'data' => new CArrayDataProvider($bidInfo),
  			'pager' => $pager
		));
	}
	
	/**
	 * 用于获取Ajax请求来对标段列表进行筛选
	 * 购买标段的action
	 * @param $bidId：标段id
	 * @param $userId：借款人的id
	 */
	function actionInfo() {
		$bid = BidInfo::model()->with('user','bidMeta')->findByPk($this->getQuery('id'));
		if(empty($bid))
			throw new CHttpException(404);
		$this->setPageTitle ( $bid->getAttribute ( 'title' ) . ' - ' . $this->name );
		$model = new MetaForm ();
		if (! empty ( $_POST )) {
			if ($this->user->getIsGuest () === true) {
				$this->loginRequired ();
			}
			
			$model->attributes = array (
					'bid' => $bid->getAttribute ( 'id' ),
					'sum' => $this->getPost ( 'sum' ),
					'code' => $this->getPost ( 'code' ),
					'protocal' => $this->getPost ( 'protocal' ) 
			);
			
			if ($model->validate ()) {
				if (($metano = $model->save ()) !== 0) {
					$this->redirect ( $this->createUrl ( 'platform/order', array (
							'metano' => Utils::appendEncrypt ( $metano ) 
					) ) );
				} else { // 满标
					$this->render ( 'failure' );
				}
			}
		}
		
		$meta = BidMeta::model ()->with ( 'user' )->findAll ( array (
				'order' => 'buy_time DESC',
				'condition' => 'bid_id=' . $bid->getAttribute ( 'id' ) 
		) );
		
		$bider = $bid->getRelated ( 'user' );
		$credits = $this->app->getModule ( 'credit' )->getComponent ( 'userCreditManager' )->getPassedCredit ( $bider->id, $bider->role );
		$this->render ( 'info', array (
				'bid' => $bid,
				'bider' => $bider,
				'credits' => $credits,
				'form' => $model,
				'meta' => new CArrayDataProvider ( $meta ),
				'user' => $this->app->getModule ( 'user' )->userManager->getUserInfo ( $this->user->getId () ),
				'authGrade' => $this->app->getModule ( 'credit' )->getComponent ( 'userCreditManager' )->getUserCreditLevel ( $bider->getAttribute ( 'id' ) ) 
		) );
	}
	
	/**
	 * 用于获取Ajax请求
	 */
	function actionAjaxBids() {
		$criteria = new CDbCriteria();
		$criteria->condition = 'verify_progress=21 AND start<='.time();

		$conditions = array();
		$withUser = false;
		
		$this->loadCreditSettings();
		
		foreach ($this->_selectorMap as $key => $value) {
			if(isset($_GET[$key]) && isset($value[$_GET[$key]]) && $value[$_GET[$key]] !== 'all') {
				$conditions[$key] = $_GET[$key];
				$condition = $value[$_GET[$key]];
				if ( $key === 'authenGrade' ){
					$criteria->with = array(
							'user' => array(
									'condition' => $condition
							)
					);
					$withUser = true;
				}else {
					$criteria->addCondition($condition);
				}
			}
		}
		
		$pager = new CPagination(BidInfo::model()->count($criteria));
		$pager->setPageSize($this->_bidsPerPage);
		$pager->applyLimit($criteria);
		$pager->params = $conditions;
		
		$criteria->order = 'pub_time DESC';
		if ( $withUser === false ){
			$criteria->with = array('user');
		}
		$data = BidInfo::model()->findAll($criteria);
		
		$return = array();
		$bidProgressCssClassMap = $this->app['bidProgressCssClassMap'];
		
		$credit = Yii::app()->getModule('credit')->getComponent('userCreditManager');
		$userManager = $this->app->getModule('user')->userManager;
		foreach($data as $key => $value) {
			$return[$key] = $value->getAttributes();
			$return[$key]['progress'] = $value->getAttribute('progress')/100;
			$return[$key]['avatar'] = $userManager->getUserIcon($value->user_id);
			$return[$key]['month_rate'] /= 100;
			$return[$key]['sum'] = number_format($return[$key]['sum']/100,2);
			$return[$key]['titleHref'] = $this->createUrl('purchase/info', array('id' => $value->getAttribute('id')));
			$return[$key]['authGrade'] = $credit->UserLevelCaculator($value->user->credit_grade);
			//$return[$key]['bidding'] = 0;//正在招标
			//if ( $value->verify_progress == 31  ){
			//	$return[$key]['bidding'] = 1;//满标
			//}
			$return[$key]['processClass'] = '';
			foreach ( $bidProgressCssClassMap as $x => $bidProgressCssClass ){
				if ( ($return[$key]['progress']) <= $x ){
					$return[$key]['processClass'] = $bidProgressCssClass;
				}
			}
		}
		
		$this->response(200,'ok',array(
				'state' => 1,
				'content' => $return,
				'pageHtml' => $this->renderPartial('//common/pager',array('pager'=>$pager),true),
				'pageSize' => $this->_bidsPerPage
		));
	}

	/**
	 * 购买标段的action
	 * @param $bidId：标段id
	 * @param $userId：借款人的id
	 */
	/*function actionPurchaseBid() {
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
	}*/
	
	/**
	 * 购买标段的Ajax请求
	 */
	function actionPurchaseBidAjax() {
		$bidId = $this->getQuery('bidId',null);//标段id
		$lendNum = $this->getQuery('lendNum');//投资金额
		
		if(is_numeric($lendNum)) {//判断输入的金额是不是数字
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

}