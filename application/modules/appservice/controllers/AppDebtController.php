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
}	
?>