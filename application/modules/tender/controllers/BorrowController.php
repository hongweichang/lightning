<?php
/**
 * 我要借款的控制器
 * @author even
 */

class BorrowController extends Controller {
	public $defaultAction = "roleChoose"; // 更改默认的action,默认要选择社会角色：工薪阶层，企业主，网店店主
	
	public function filters() {
		return array();
	}
	public function init() {
		parent::init();
		Yii::import( 'application.modules.tender.models.*' );
		//Yii::import( 'application.modules.tender.components.*' );
	}

	/**
	 * 默认action，进行社会角色选择
	 * 社会角色默认有3种：工薪阶层，企业主，网店店主
	 * 用户角色从user里面取得
	 */
	function actionRoleChoose() {
//		$role = $this->user->getState("role");
		$role = "工薪阶层";
//		CVarDumper::dump($role);
		$this->render("roleChoose",array('role'=>$role));
	}
	
	/**
	 * 调用接口，判断用户信息是否齐全，即是否达到发标的要求
	 */
	function checkUserInfo() {
		
	}
	
	/**
	 * 填写借款信息之前，应该做相应的权限和金额条件检查
	 * 填写借款信息
	 */
	function actionWriteBorrowInfo() {
		$data = array();//传递给view的数据数组
		
//		$userCenter = $this->user->userCenter;//获得个人中心的url
//		$help = $this->helpUrl;//获得使用帮助的url
		
		$userCenter = "borrow/roleChoose";
		$help = "borrow/roleChoose";
		$postUrl = "borrow/borrowInfoToDB";//将表单写入数据库的action
		
		/**
		 * 问题。。。。
		 * Enter description here ...
		 * @var unknown_type
		 */
		$data['userCenter'] = $userCenter;
		$data['help'] = $help;
		$data['postUrl'] = $postUrl;
		
		$this->render("writeBorrowInfo",array('data'=>$data));
	}
	
	/**
	 * 将标段信息插入数据库的action
	 */
	public function actionBorrowInfoToDB() {
		$model = new BidInfo;
		if(isset($_POST['writeBidInfoForm'])) {
//			$_POST['writeBidInfoForm']['user_id'] = $this->app->getModule('user')->getComponent('userManager');//招标用户就是当前用户
			$_POST['writeBidInfoForm']['user_id'] = 21;//测试用户的id：21
			$_POST['writeBidInfoForm']['start'] = time();//招标开始时间是当前时间
//			招标结束时间是怎么确定的呢？？
			$_POST['writeBidInfoForm']['end'] = time();
			$model->attributes = $_POST['writeBidInfoForm'];//利用表单来填充
			echo $model->save(),"333333";die();
			if($model->save()){//如果发标成功
				echo "开始插入数据库";
				$id = $model->getDbConnection()->getLastInsertID();//获得最后一次插入记录的id
				echo "最后插入数据库的id是：";die();
				$this->actionViewInfo($id);//转到审核提示页面
			} else {
				echo "出错了";
			}
		} else {
			echo "出错了";
		}
	}
	
	/**
	 * 显示标段详情，并且提示审核的信息页面
	 * @param $id ：最后一次插入的记录的id
	 */
	function actionViewInfo() {
		// 根据主键来取出刚刚插入的记录
		$model = BidInfo::model()->findByPk( 2 );
		// 显示购买详情的页面
		$this->render( 'viewBidInfo', array('model' => $model) );
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
	
	public function wxweven($data,$die = true) {
		echo "<pre>";
		print_r($data);
		if($die)
			die();
	}
}