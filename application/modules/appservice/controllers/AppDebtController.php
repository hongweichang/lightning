<?php
/*
**债权模块API服务
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/

class AppDebtController extends Controller{

	public function filters(){
		return array();
	}
	/*
	**获取债权列表
	*/
	public function actionGetDebt(){
		$debtData = Debt::model()->findAll();
		$debtList = array();

		if(!empty($debtData)){
			foreach($debtData as $value){

				$debtList[] = array(
							'title'=>$value->title,
							'description'=>$value->description,
							'incomeWay'=>$value->incomeWay,
							'start'=>$value->start,
							'end'=>$value->end,
							'condition'=>$value->condition,
							'deadline'=>$value->deadline,
							'charge'=>$value->charge,
							'protection'=>$value->protection,
							'remark'=>$value->remark,

						);
			}

			$this->response('200','查询成功',$debtList);
		}else{
			$this->response('400','暂无债权');
		}

	}

	/*
	**加入债权
	*/
	public function actionJoinDebt(){
		$post = $this->getPost();
		$uid = Yii::app()->user->id;

		if(!empty($post['id'])){
			$id = $post['id'];
			$model = new DebtUser;
			$model->user_id = $uid;
			$model->did = $id;

			if($model->save()){
				$this->response('200','操作成功');
			}else
				$this->response('400','添加失败',$model->getErrors());
		}else
			$this->response('400','参数错误');
	}
}	
?>