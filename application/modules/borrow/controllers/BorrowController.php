<?php
/**
 * 我要借款的控制器
 * @author even
 *
 */

class BorrowController extends CmsController {
	public $defaultAction = "roleChoose"; // 更改默认的action,默认要选择社会角色：工薪阶层，企业主，网店店主
	
	public function filters() {
		return array();
	}
	public function init() {
		parent::init();
		Yii::import( 'application.modules.borrow.models.*' );
		Yii::import( 'application.modules.borrow.components.*' );
	}

	/**
	 * 默认action，进行社会角色选择
	 * 社会角色默认有3种：工薪阶层，企业主，网店店主
	 */
	function actionRoleChoose() {
		//这应该是个静态页面,直接render
		$this->render("roleChoose");
	}
	
	/**
	 * 调用接口，判断用户信息是否齐全，即是否达到发标的要求
	 */
	function checkUserInfo() {
		
	}
	
	
	/**
	 * 前面的检测成功后，开始填写标段信息，提交审核
	 */
	public function actionSuccess(){
		$this->actionCreateInfo();//调用添加信息的action
		
	}
	
	public function actionFailed(){
		$this->app->getComponent('urlManager')->error();
	}
	
	/**
	 * 填写标段信息的action
	 */
	public function actionCreateInfo() {
		$model = new BidInfo;
		$this->render('writeBidInfo',array('model'=>$model));
		
		if(isset($_POST['writeBidInfoForm'])) {
			$model->attributes = $_POST['writeBidInfoForm'];//利用表单来填充
			if($model->save()){//如果发标成功
				$id = $model->getDbConnection()->getLastInsertID();//获得最后一次插入记录的id
				$this->actionViewInfo($id);//显示发标详情
			}
		}
	}
	
	/**
	 * 显示发标详情页
	 * @param $id ：最后一次插入的记录的id
	 */
	function actionViewInfo($id) {
		// 根据主键来取出刚刚插入的记录
		$model = BidIndo::model()->findByPk( $id );

		// 显示购买详情的页面
		$this->render( 'viewBidInfo', array('model' => $model) );
	}

	/**
	 * 发标成功的处理函数
	 */
	function actionSuccess() {
		/**
		 * 购买成功相应的处理
		 */
	}

	/**
	 * 发标失败的处理函数
	 */
	function actionFailure() {
		/**
		 * 失败处理功能：跳转到错误页面或者其他。。。
		 */
	}

}