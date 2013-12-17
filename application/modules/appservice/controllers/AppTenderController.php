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
			$BidInfo = array();

			$criteria = $this->CriteriaMake($condition,$order,$page);

			if(!is_object($criteria)){

				$this->response('401','查询失败，参数错误','');
			}

			$criteria->with = array('user');
			$BidData = $this->app->getModule('tender')->getComponent('bidManager')->getBidList($criteria);

			if(!empty($BidData)){
				foreach($BidData as $value){
					$Icon = $this->app->getModule('user')->userManager->getUserIcon($value->getRelated('user')->id);
					$Credit = $this->app->getModule('credit')->userCreditManager->getUserCreditLevel($value->getRelated('user')->id);

					$BidInfo[] = array(
							'id'=>$value->attributes['id'],
							'uid'=>$value->getRelated('user')->id,
							'nickname'=>$value->getRelated('user')->nickname,
							'title'=>$value->attributes['title'],
							'Content'=>$value->attributes['description'],
							'sum'=>$value->attributes['sum'],
							'rate'=>$value->attributes['month_rate'],
							'TimeLimit'=>$value->attributes['deadline'],
							'Start'=>$value->attributes['start'],
							'Over'=>$value->attributes['end'],
							'Icon'=>$Icon,
							'creditLevel'=>$Credit

						);
				}
				
				$this->response('200','查询成功',$BidInfo);
			}else
				$this->response('400','暂无标段信息','');
			
		}
	}

	/*
	**获取当前用户标段列表
	*/
	public function actionGetBidListById(){
		$uid = Yii::app()->user->id;

		$BidData = $this->app->getModule('tender')->getComponent('bidManager')->getBidList('user_id =:uid',
			array(':uid'=>$uid));

		if(empty($BidData))
			$this->response('400','该用户无标段','');
		else{
			foreach($BidData as $value){
				$BidList[] = array(
						'data'=>$value->attributes,
					);
			}
			$this->response('200','查询成功',$BidList);
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
			$BidData = $this->app->getModule('tender')->getComponent('bidManager')->getBidInfo($id);

			if(!empty($BidData)){
				$BidInfo = $BidData->attributes;
				$this->response('200','查询成功',$BidInfo);
			}else
				$this->response('400','查询失败,该标段不存在','');

			
		}else
			$this->response('401','查询失败，参数错误','');
	}

	
	/*
	**发布标段
	*/
	public function actionRaiseBid(){
		$post = $this->getPost();

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
		}
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

		if(!empty($post)){
			$action = $post['action'];
			$criteria = new CDbCriteria;
			$criteria->alias = 'meta';

			if($action == 'unfull'){
				
				$criteria->condition = 'progress < :progress AND meta.user_id =:uid AND finish_time != 0';
							$criteria->params = array(
								':progress'=>100,
								'uid'=>$uid,
							);
				$metaData = BidMeta::model()->with('bid','user')->findAll($criteria);

				if(!empty($metaData)){
					foreach($metaData as $value){
						$bidUser_id = $value->getRelated('user')->id;
						$userIcon =  $this->app->getModule('user')->userManager->getUserIcon($bidUser_id);

						$meataList[] = array(
									'id'=>$value->getRelated('bid')->id,
									'title'=>$value->getRelated('bid')->title,
									'description'=>$value->getRelated('bid')->description,
									'TimeLimit'=>$value->getRelated('bid')->deadline,
									'sum'=>$value->getRelated('bid')->sum,
									'investMoney'=>$value->sum,
									'uid'=>$value->getRelated('user')->id,
									'nickname'=>$value->getRelated('user')->nickname,
									'userIcon'=>$userIcon

								);
					}

					$this->response('200','查询成功',$meataList);

				}else{
					$this->response('400','暂无投标记录','');
				}

			}elseif($action == 'full'){
				
				$criteria->condition = 'progress =:progress AND meta.user_id =:uid AND finish_time != 0';
				$criteria->params = array(
								':progress'=>100,
								'uid'=>$uid,
							);
				$metaData = BidMeta::model()->with('bid','user')->findAll($criteria);

				if(!empty($metaData)){
					foreach($metaData as $value){
						$bidUser_id = $value->getRelated('user')->id;
						$userIcon =  $this->app->getModule('user')->userManager->getUserIcon($bidUser_id);

						$meataList[] = array(
									'id'=>$value->getRelated('bid')->id,
									'title'=>$value->getRelated('bid')->title,
									'description'=>$value->getRelated('bid')->description,
									'TimeLimit'=>$value->getRelated('bid')->deadline,
									'sum'=>$value->getRelated('bid')->sum,
									'investMoney'=>$value->sum,
									'uid'=>$value->getRelated('user')->id,
									'nickname'=>$value->getRelated('user')->nickname,
									'userIcon'=>$userIcon

								);
					}
					$this->response('200','查询成功',$meataList);

				}else{
					$this->response('400','暂无投标记录','');
				}

			}else{
				$this->response('401','参数不合法','');
			}


		}

		
	}

}
?>