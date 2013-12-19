<?php
/**
 * 我要借款的控制器
 * @author even
 */

class BorrowController extends Controller {
<<<<<<< HEAD
//	public $defaultAction = "roleChoose"; // 更改默认的action,默认要选择社会角色
	
	public function noneLoginRequired(){
		return '';
	}
	
	private $name = '我要借贷';
	private $role;
	
	public function init(){
		parent::init();
		if($userRole = $this->user->getState("role")) {
			$this->role = $this->app['roleMap'][$userRole];
=======
	private $name = '我要借贷';
	private $role;
	public $defaultAction = "roleChoose"; // 更改默认的action,默认要选择社会角色
	
	public function init() {
		parent::init();
		Yii::import( 'application.modules.tender.models.*' );
		Yii::import( 'application.modules.tender.components.*' );
		
		$roleName = $this->user->getState("role");
		if ( isset($this->app['roleMap'][$roleName]) ){
			$this->role = $this->app['roleMap'][$roleName];
		}else {
			$this->role = null;
>>>>>>> d422edd5dac7e79228e1e3ba22e259ffc4b84401
		}
	}
	
	/**
	 * 默认action，进行社会角色选择
	 * 社会角色默认有3种：工薪阶层，企业主，网店店主
	 * 用户角色从user里面取得
	 */
<<<<<<< HEAD
	function actionIndex() {
		$this->setPageTitle($this->name.' - '.$this->app->name);
=======
	function actionRoleChoose() {
		$this->setPageTitle($this->name);
>>>>>>> d422edd5dac7e79228e1e3ba22e259ffc4b84401
		
		$user = $this->app->getModule('user');
		//检查信息是否完善
		$role = $this->user->getState("role");
		$roleName = false;
		$map = $this->app['roleMap'];
		if ( isset($map[$role]) ){
			$roleName = $map[$role];
		}
<<<<<<< HEAD

		$this->render("index",array(
			'roleName' => $this->role
		));
=======
		$this->render("index",array('roleName'=>$roleName));
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
			$this->render("index",array('roleName' => $this->role));
		}
>>>>>>> d422edd5dac7e79228e1e3ba22e259ffc4b84401
	}
	
	/**
	 * 填写借款信息之前，应该做相应的权限和金额条件检查
	 * 填写借款信息
	 */
	function actionInfo() {
		$this->setPageTitle($this->role.' - '.$this->name);
		
		$model = new BidForm();
		if(!empty($_POST)){
			$model->attributes = array(
				'title' => $this->getPost('title'),
				'sum' => $this->getPost('sum'),
				'rate' => $this->getPost('rate'),
				'deadline' => $this->getPost('deadline'),
				'start' => $this->getPost('start'),
				'end' => $this->getPost('end'),
				'desc' => $this->getPost('desc')
			);
			
			if($model->validate()){
<<<<<<< HEAD
				$this->redirect($this->createUrl('borrow/success',array(
					'id' => $model->save()
				)));
//				$this->wxweven($model->save());
=======
				$this->redirect( $this->createUrl('borrow/viewInfo',array('id' => $model->save(false) )));
>>>>>>> d422edd5dac7e79228e1e3ba22e259ffc4b84401
			}
		}
		
		$this->render("info",array(
			'role' => $this->role,
			'form' => $model
		));
	}
	
	/**
	 * 显示标段详情，并且提示审核的信息页面
	 */
<<<<<<< HEAD
	function actionSuccess() {
=======
	function actionViewInfo() {
>>>>>>> d422edd5dac7e79228e1e3ba22e259ffc4b84401
		//利用传递过来的id参数
		$id = $this->getQuery('id',0);
		// 根据主键来取出刚刚插入的记录
		$model = BidInfo::model()->findByPk($id);
<<<<<<< HEAD
//		print_r($model);die;

=======
		//print_r($model);
>>>>>>> d422edd5dac7e79228e1e3ba22e259ffc4b84401
		//只能查看自己的信息，将session里面的user_id和数据库里面的user_id作比较
		if(!empty($model) && $this->user->getId() === $model->user_id){
			$this->setPageTitle($model->getAttribute('title').' - '.$this->role.' - '.$this->name.' - '.$this->app->name);
			$this->render( 'view', array(//显示详情页
				'role' => $this->role,
				'model' => $model
			));
		}else{
			echo "错误";
		}
	}
<<<<<<< HEAD
	
	public function wxweven($data,$die = true) {
		echo "<meta charset='utf-8'>";
		echo "<pre>";
		print_r($data);
		if($die)
			die();
	}
=======
>>>>>>> d422edd5dac7e79228e1e3ba22e259ffc4b84401
}