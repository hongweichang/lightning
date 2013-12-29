<?php
/*
**标段模块API服务
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/
class AppTenderController extends Controller{

	private $tenderPageSize = 10;

	public function filters(){
		return array();
	}

	public function actionIndex(){
		echo "ok";
	}

	/*
	**获取标段列表
	*/
	public function actionGetBidList(){
		$post = $this->getPost();
		if(!empty($post)){
			$condition = $post['condition'];
			$order = $post['order'];
			$page = $post['page'];
			$bidInfo = array();

			$cache = $this->app->cache;
			$cacheKey = 'APP_GET_BID_LIST'.$condition.$order.$page;
			if ( $cache !== null ){
				$bidInfo = $cache->get($cacheKey);
				if ( $bidInfo !== false ){//cache response
					$this->response('200','查询成功',$bidInfo);
				}
			}
			
			$criteria = $this->CriteriaMake($condition,$order,$page);
			if(!is_object($criteria)){
				$this->response('401','查询失败，参数错误','');
			}
			$criteria->with = array('user');
			
			$bidData = $this->app->getModule('tender')->getComponent('bidManager')->getBidList($criteria);
			if(!empty($bidData)){
				foreach($bidData as $value){
					$Icon = $this->app->getModule('user')->userManager->getUserIcon($value->getRelated('user')->id);
					$Credit = $this->app->getModule('credit')->userCreditManager->UserLevelCaculator($value->getRelated('user')->credit_grade);

					$bidInfo[] = array(
							'id'=>$value->id,
							'uid'=>$value->getRelated('user')->id,
							'nickname'=>$value->getRelated('user')->nickname,
							'title'=>$value->title,
							'Content'=>$value->description,
							'sum'=>$value->sum,
							'rate'=>$value->month_rate,
							'TimeLimit'=>$value->deadline,
							'Start'=>$value->start,
							'Over'=>$value->end,
							'Icon'=>$Icon,
							'progress'=>$value->progress,
							'verify_progress'=>$value->verify_progress,
							'creditLevel'=>$Credit

						);
				}
				
				if ( $cache !== null ){
					$cache->set($cacheKey,$bidInfo,300);
				}
				
				$this->response('200','查询成功',$bidInfo);
			}else{
				$this->response('400','暂无标段信息','');
			}
			
		}
	}

	/*
	**获取当前用户标段列表
	*/
	public function actionGetBidListById(){
		$uid = Yii::app()->user->id;

		$cache = $this->app->cache;
		$cacheKey = 'APP_GET_USER_BID_LIST'.$uid;
		if ( $cache !== null ){
			$bidList = $cache->get($cacheKey);
			if ( $bidList !== false ){
				$this->response('200','查询成功',$bidList);
			}
		}
		
		$bidData = $this->app->getModule('tender')->getComponent('bidManager')->getBidList('user_id =:uid',array(':uid'=>$uid));
		if(empty($bidData)){
			$this->response('400','该用户无标段','');
		}else{
			foreach($bidData as $value){
				$bidList[] = array(
						'data'=>$value->attributes,
					);
			}
			
			if ( $cache !== null ){
				$bidList = $cache->set($cacheKey,$bidList,600);
			}
			$this->response('200','查询成功',$bidList);
		}

	}

	/*
	**生成查询条件
	*/
	public function CriteriaMake($condition,$order,$page){
		if(!empty($condition) && !empty($order) && !empty($page)){
			$criteria = new CDbCriteria;
			switch ($condition) {
				case 'rate':
					$criteria_condition = 'month_rate';
					break;

				case 'startTime':
					$criteria_condition = 'start';
					break;

				case 'credit':
					$criteria_condition = 'credit_grade';
					break;

				case 'sum':
					$criteria_condition = 'sum';
					break;

				default:
					$criteria_condition = null;
					break;
			}

			switch ($order) {
				case 'up':
					$criteria_order = 'ASC';
					break;

				case 'down':
					$criteria_order = 'DESC';
					break;

				default:
					$criteria_order = null;
					break;
			}

			if($criteria_order !== null && $criteria_condition !== null){
				$criteria->order = $criteria_condition.' '.$criteria_order;
				$criteria->offset = ($page - 1)* $this->tenderPageSize;
				$criteria->limit = $this->tenderPageSize;
				$criteria->condition = 'verify_progress =:status';
				$criteria->params = array(
									'status'=>'21'
								);

				return $criteria;
			}else{
				return 401;
			}
		}else
			return 402;
	}


	/*
	**按id获取标段详情
	*/
	public function actionGetBidById(){
		$post = $this->getPost();

		if(!empty($post)){
			$id = $post['id'];
			
			$cache = $this->app->cache;
			$cacheKey = 'APP_GET_BID_BY_ID'.$id;
			if ( $cache !== null ){
				$bidInfo = $cache->get($cacheKey);
				if ( $bidInfo !== false ){
					$this->response('200','查询成功',$bidInfo);
				}
			}
			
			$bidData = $this->app->getModule('tender')->getComponent('bidManager')->getBidInfo($id);

			if(!empty($bidData)){
				$bidInfo = $bidData->attributes;
				if ( $cache !== null ){
					$cache->set($cacheKey,$bidInfo,600);
				}
				$this->response('200','查询成功',$bidInfo);
			}else{
				$this->response('400','查询失败,该标段不存在','');
			}
		}else{
			$this->response('401','查询失败，参数错误','');
		}
	}

	
	/*
	**发布标段
	*/
	public function actionRaiseBid(){
		$post = $this->getPost();
		
		$loanable = $this->app->getModule('credit')->userCreditManager->UserBidCheck();

		if($loanable === false){
			$this->response('400','发标失败,当前会员级别无法发标');
			exit();
		}

		if(!empty($post)){
			$uid = Yii::app()->user->id;
			//$uid = 23;
			$title = $post['title'];
			$description = $post['description'];
			$sum= $post['sum'];
			$month_rate = $post['rate'];
			$start = $post['start'];
			$end = $post['end'];
			$deadline = $post['deadline'];

			$raiseBid = $this->app->getModule('tender')->getComponent('bidManager')->raiseBid($uid,$title,$description,$sum,
				$month_rate,$start,$end,$deadline);

			if($raiseBid !== 0)
				$this->response('200','投标成功','');
			else
				$this->response('400','投标失败','');
		}else
			$this->response('400','投标失败,信息不完善');
	}


	/*
	**投标接口
	*/

	public function actionPurchaseBid(){
		$post = $this->getPost();

		if(!empty($post)){
			$bidId = $post['id'];
			$sum = $post['sum'];
			$user_id = Yii::app()->user->id;

			$purchaseBid = $this->app->getModule('tender')->getComponent('bidManager')->purchaseBid($user_id,$bidId,$sum);
			if($purchaseBid === false)
				$this->response('401','金额超过该标段限制','');
			elseif($purchaseBid == 0)
				$this->response('400','投标失败，参数错误','');
			else
				$this->response('200','投标成功',$purchaseBid);
		}
	}


	/*
	**获取用户投标信息
	*/
	public function actionGetMetaList(){
		$uid = $this->user->id;
		$post = $this->getPost();
		
		if(!empty($post)):
			$action = $post['action'];
			
			$cache = $this->app->cache;
			$cacheKey = 'APP_GET_BID_META_BY_UID_ACTION'.$action.$uid;
			if ( $cache !== null ){
				$metaList = $cache->get($cacheKey);
				if ( $metaList !== false ){
					$this->response('200','查询成功',$metaList);
				}
			}
			
			$criteria = new CDbCriteria;
			$criteria->alias = 'meta';
			
			if ( $action === 'unfull' ){
				$criteria->condition = 'verify_progress = 21 AND meta.user_id =:uid AND status =:status';
			}elseif ( $action === 'full' ){
				$criteria->condition = 'verify_progress = 31 AND meta.user_id =:uid AND status =:status';
			}else{
				$this->response('401','参数不合法','');
			}
			
			$criteria->params = array(
					':uid'=>$uid,
					':status'=>'21'
			);
			$metaData = BidMeta::model()->with('bid','user')->findAll($criteria);
			
			if(!empty($metaData)){
				foreach($metaData as $value){
					$bid = $value->getRelated('bid');
					$user = $value->getRelated('user');
					$userLevel = $this->app->getModule('credit')->userCreditManager->UserLevelCaculator($user->credit_grade);
					$bidUser_id = $user->id;
					$userIcon =  $this->app->getModule('user')->userManager->getUserIcon($bidUser_id);
					
					$metaList[] = array(
							'id'=>$bid->id,
							'title'=>$bid->title,
							'description'=>$bid->description,
							'TimeLimit'=>$bid->deadline,
							'sum'=>$bid->sum,
							'investMoney'=>$value->sum,
							'uid'=>$user->id,
							'nickname'=>$user->nickname,
							'gender'=>$user->gender,
							'realname'=>$user->realname,
							'userLevel'=>$userLevel,
							'userIcon'=>$userIcon
			
					);
				}
			
				if ( $cache !== null ){
					$cache->set($cacheKey,$metaList,300);
				}
				$this->response('200','查询成功',$metaList);
			}else{
				$this->response('400','暂无投标记录','');
			}
		endif;

		
	}

}
?>