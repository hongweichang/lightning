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
	public function init() {
		parent::init();
		Yii::import( 'application.modules.tender.models.*' );
		Yii::import( 'application.modules.tender.components.*' );
		$this->user->getState('avatar');//获取头像url
	}
	
	/**
	 * 默认action，显示所有的标段
	 * 利用CListview
	 */
	function actionShowAllBids() {
		$selector = $this->getPost('selector');
		$selectorMap = array(
				'monthRate' => array(
						'all' => '',
						'monthRate1' => ' month_rate between 5 and 10 ',
						'monthRate2' => ' month_rate between 10 and 15 ',
						'monthRate3' => ' month_rate between 15 and 20 ',
				),
				'deadline' => array(
						'all' => '',
						'betwen3and6' => ' deadline between 3 and 6 ',
						'betwen6and9' => ' deadline between 6 and 9 ',
						'betwen9and12' => ' deadline between 9 and 12 ',
				),
				'authenGrade' => array(
						'all' => '',
						'authenGrade1' => " authenGrade = 'AA' ",
						'authenGrade2' => " authenGrade = 'AAA' ",
						'authenGrade3' => " authenGrade = 'HR' ",
				),
				
		);
		
		$criteria = new CDbCriteria();
		$criteria->condition = 'verify_progress=1 AND start < '.time();
		$criteria->order = 'start DESC';
		
		if ( isset($x) ){
			$criteria->addCondition();
		}
		
		$dataProvider = new CActiveDataProvider('BidInfo',array(
				'criteria' => $criteria,
				'countCriteria' => array(
						'condition' => $criteria->condition,
				),
				'pagination'=>array(
						'pageSize' => 10
				)
		));
		
//		$this->wxweven($dataProvider);
  		//月利率的查询条件
		$monthRate = array(
						'condition1'=>'5%-10%',
						'condition2'=>'10%-15%',
						'condition3'=>'15%-20%',
		);
		//借款期限的查询条件
		$deadline = array(
						'condition1'=>'3-6',
						'condition2'=>'6-9',
						'condition3'=>'9-12',
		);
		//认证等级的查询条件
		$authenGrade = array(
						'condition1'=>'AA',
						'condition2'=>'AAA',
						'condition3'=>'HR',
		);

  		$this->render('showAllBids',array(
  			'monthRate' => $monthRate,
  			'deadline' => $deadline,
  			'authenGrade' => $authenGrade,
         	'dataProvider' => $dataProvider,
		));
		/*$model = BidInfo::model();
		
		// 分页的使用
		$criteria = new CDbCriteria();
		$criteria->addCondition( 'verify_progress=1' ); // 1代表审核通过
		
		$count = $model->count( $criteria );
		$pager = new CPagination( $count );
		$pager->pageSize = 20; // 每页显示的条数
		$pager->applyLimit( $criteria );
		
		$data = $model->findAll( $criteria );
		CVarDumper::dump( $data );
		// 显示全部标段的view
		// $this->render("showAllBid",array("data"=>$data,'pager'=>$pager));*/
	}
	
	/**
	 * 显示标段详细信息
	 * @param $bidId:标段id
	 * @param $userId:对应标段的user_id
	 */
	function acrtionShowBidDetail($bidId, $userId) {
		$bidDetail = BidInfo::model(); // 标段信息对应的表
		                               
		// 调用其他组件接口，获得发标人的信息
		// $userInfo = Yii::app->getComponent('userInfo')->getInfo($userId);
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
	 * 购买对应的标段action
	 * 
	 * @param
	 *        	$userId:购买用户的user_id
	 * @param
	 *        	$bidId:要购买的标段id
	 * @param
	 *        	$money:购买的金额
	 */
	function actionCreatePurchase() {
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