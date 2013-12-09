<?php
/**
 * 我要借款的控制器
 * @author even
 */

class BorrowController extends Controller {
	private $name = '我要借贷';
	private $role;
	
	public function init(){
		parent::init();
		
		$this->role = $this->app['roleMap'][$this->user->getState("role")];
	}
	
	/**
	 * 默认action，进行社会角色选择
	 * 社会角色默认有3种：工薪阶层，企业主，网店店主
	 * 用户角色从user里面取得
	 */
	function actionIndex() {
		$this->setPageTitle($this->name.' - '.$this->app->name);
		
		$user = $this->app->getModule('user');
		//检查信息是否完善
		$role = $this->user->getState("role");
		$roleName = false;
		$map = $this->app['roleMap'];
		if ( isset($map[$role]) ){
			$roleName = $map[$role];
		}
		
		$this->render("index",array(
			'roleName' => $this->role
		));
	}
	
	/**
	 * 填写借款信息之前，应该做相应的权限和金额条件检查
	 * 填写借款信息
	 */
	function actionInfo() {
		$this->setPageTitle($this->role.' - '.$this->name.' - '.$this->app->name);
		
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
				$this->redirect($this->createUrl('borrow/success',array(
					'id' => $model->save()
				)));
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
	function actionSuccess() {
		//利用传递过来的id参数
		$id = $this->getQuery('id',0);
		// 根据主键来取出刚刚插入的记录
		$model = BidInfo::model()->findByPk($id);
		//print_r($model);
		//只能查看自己的信息，将session里面的user_id和数据库里面的user_id作比较
		if(!empty($model) && $this->user->getId() === $model->user_id){
			$this->setPageTitle($model->getAttribute('title').' - '.$this->role.' - '.$this->name.' - '.$this->app->name);
			$this->render( 'view', array(//显示详情页
				'role' => $this->role,
				'model' => $model
			));
		}else{
			//404
		}
	}
}