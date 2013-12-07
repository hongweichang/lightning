<?php
/**
 * 我要借款的控制器
 * @author even
 */

class BorrowController extends Controller {
	public $defaultAction = "roleChoose"; // 更改默认的action,默认要选择社会角色：工薪阶层，企业主，网店店主
	
	public function noneLoginRequired(){
		return '';
	}
	
	public function init() {
		parent::init();
//		Yii::import( 'application.modules.tender.models.*' );
		//Yii::import( 'application.modules.tender.components.*' );
	}

	/**
	 * 默认action，进行社会角色选择
	 * 社会角色默认有3种：工薪阶层，企业主，网店店主
	 * 用户角色从user里面取得
	 */
	function actionRoleChoose() {
		//检查信息是否完善
		$roleName = $this->user->getState("role");
		/*$roleName = '还未填写角色名字';//角色名字
		$map = $this->app['roleMap'];
		$this->wxweven($map);
		if ( isset($map[$role]) ){
			$roleName = $map[$role];
		}*/
		
		$this->render("roleChoose",array('roleName'=>$roleName));
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
		
		$userCenter = "#";
		$help = "#";
		$postUrl = "borrow/borrowInfoToDB";//将表单写入数据库的action
		
		/**
		 * Enter description here ...
		 * @var unknown_type
		 */
		$data['userCenter'] = $userCenter;
		$data['help'] = $help;
		$data['postUrl'] = $postUrl;
		$this->createUrl('/site');
		$this->render("writeBorrowInfo",array('data'=>$data));
	}
	
	/**
	 * 将标段信息插入数据库的action
	 */
	public function actionBorrowInfoToDB() {
		$model = new BidInfo();//如果是向数据库插入记录，需要用 new modelClass
		if(isset($_POST['writeBidInfoForm'])) {
			$_POST['writeBidInfoForm']['user_id'] = $this->user->getId();//测试用户的id：21
			/**
			 * 将前台提交过来的招标开始时间和结束时间转化为时间戳后存入数据库
			 */
			$_POST['writeBidInfoForm']['start'] = strtotime($_POST['writeBidInfoForm']['start']);
			$_POST['writeBidInfoForm']['end'] = strtotime($_POST['writeBidInfoForm']['end']);

			//获取用户认证等级
			$_POST['writeBidInfoForm']['authenGrade'] = Yii::app()->getModule('credit')->
					getComponent('userCreditManager')->getUserCreditLevel($this->user->getId());
			$model->attributes = $_POST['writeBidInfoForm'];//利用表单来填充
//			$this->wxweven($model->attributes);
			if($model->save()){//如果发标成功
				$id = $model->getDbConnection()->getLastInsertID();//获得最后一次插入记录的id
				
				$this->redirect($this->createUrl('borrow/viewInfo',array('id'=>$id)));//跳转到显示详情页面
			} else {
				$this->redirect("errorUrl",array("errMes"=>"出错了"));
			}
		} else {
			echo "出错了";
		}
	}
	
	/**
	 * 显示标段详情，并且提示审核的信息页面
	 */
	function actionViewInfo() {
		//利用传递过来的id参数
		$id = $this->getQuery('id',null);
		// 根据主键来取出刚刚插入的记录
		$model = BidInfo::model()->findByPk($id);
		//只能查看自己的信息，将session里面的user_id和数据库里面的user_id作比较
		if($this->user->getId() === $model->user_id) {
			$this->render( 'viewBidInfo', array('model' => $model) );//显示详情页
		} else {
			$this->redirect('errorUrl','错误');//错误页面
		}
	}
	
	/**
	 * 前面的检测成功后，开始填写标段信息，提交审核
	 */
	public function actionSuccess(){

	}
	
	public function actionFailed(){
		$this->app->getComponent('urlManager')->error();
	}
	
	public function wxweven($data,$die = true) {
		echo "<meta charset='utf-8'>";
		echo "<pre>";
		print_r($data);
		if($die)
			die();
	}
}