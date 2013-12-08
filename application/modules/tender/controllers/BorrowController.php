<?php
/**
 * 我要借款的控制器
 * @author even
 */

class BorrowController extends Controller {
	public $defaultAction = "roleChoose"; // 更改默认的action,默认要选择社会角色
	
	public function noneLoginRequired(){
		return '';
	}
	
	public function init() {
		parent::init();
		Yii::import( 'application.modules.tender.models.*' );
		Yii::import( 'application.modules.tender.components.*' );
	}

	/**
	 * 默认action，进行社会角色选择
	 * 社会角色默认有3种：工薪阶层，企业主，网店店主
	 * 用户角色从user里面取得
	 */
	function actionRoleChoose() {
		$role = $this->user->getState("role");
		$roleName = '还未填写角色名字';//角色名字
		$map = $this->app['roleMap'];
		
		if ( isset($map[$role]) ){
			$roleName = $map[$role];
		}
		
		$this->render("roleChoose",array('roleName'=>$roleName));
	}
	
	/**
	 * 填写借款信息
	 */
	function actionWriteBorrowInfo() {
		$data = array();//传递给view的数据数组
		$data['userCenter'] = "#";
		$data['help'] = "#";
		$data['postUrl'] = "borrow/borrowInfoToDB";

		$this->render("writeBorrowInfo",array('data'=>$data));
	}
	
	/**
	 * 将标段信息插入数据库
	 */
	public function actionBorrowInfoToDB() {
		$model = new BidInfo();//如果是向数据库插入记录，需要用 new modelClass
		
		if(isset($_POST['writeBidInfoForm'])) {
			$_POST['writeBidInfoForm']['user_id'] = $this->user->getId();//当前登录用户的id
			
			//将前台提交过来的招标开始时间和结束时间转化为时间戳后存入数据库
			$_POST['writeBidInfoForm']['start'] = strtotime($_POST['writeBidInfoForm']['start']);
			$_POST['writeBidInfoForm']['end'] = strtotime($_POST['writeBidInfoForm']['end']);
			//将提交的金额转化为整数后，乘以100存入数据库
			$_POST['writeBidInfoForm']['sum'] = (int)trim($_POST['writeBidInfoForm']['sum']) * 100;
			
			$model->attributes = $_POST['writeBidInfoForm'];//利用表单来填充
			
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
		$id = $this->getQuery('id',null);//利用传递过来的id参数
		
		$model = BidInfo::model()->findByPk($id);// 根据主键来取出刚刚插入的记录
		//只能查看自己的信息，将session里面的user_id和数据库里面的user_id作比较
		if($this->user->getId() === $model->user_id) {
			$this->render( 'viewBidInfo', array('model' => $model) );//显示详情页
		} else {
			$this->redirect('errorUrl','错误');//错误页面
		}
	}
	
	public function wxweven($data,$die = true) {
		echo "<meta charset='utf-8'>";
		echo "<pre>";
		print_r($data);
		if($die)
			die();
	}
}