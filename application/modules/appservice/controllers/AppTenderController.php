<?php
/*
**标段模块API服务
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/
class AppTenderController extends Controller{
	
	public function filters(){
		return array();
	}

	public function actionIndex(){
		echo "ok";
	}

	public function actionGetBidList(){
		$post = $this->getPost();
		if(!empty($post)){
			$condition = $post['condition'];
			$order = $post['order'];
			$BidData = $this->app->getModule('tender')->getComponent('bidManager')->getBidList('user_id =:uid',array(':uid'=>23));
			var_dump($BidData);
		}
	}

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
}
?>