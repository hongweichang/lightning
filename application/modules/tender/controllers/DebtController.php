<?php
/*
**债权中心
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/

class DebtController extends Controller{
	public function filters(){
		return array();
	}

	/*
	**债权列表
	*/
	public function actionDebtList(){
		$criteria = new CDbCriteria;
		$criteria->order = 'start DESC';

		$DebtList = Debt::model()->findAll($criteria);
		$this->render('debtList',array('DebtList'=>$DebtList));

	}

	/*
	**债权详情
	*/
	public function actionDebtDetail($id){
		if(is_numeric($id)){
			$userData = array();
			$uid = $this->user->id;

			$debtData = Debt::model()->findByPk($id);
			if($uid != null){
				$userData = FrontUser::model()->findByPk($uid);
			}
			
			$this->render('debtDetail',array('debtData'=>$debtData,'userData'=>$userData));
		}
	}

	
	/*
	**加入债权
	*/
	public function actionJoinDebt($id){
		if(is_numeric($id)){
			$model = new DebtUser;
			$uid = $this->user->id;

			if(!empty($uid)){
				$model->user_id = $uid;
				$model->did = $id;
				if($model->save()){
					Yii::app()->user->setFlash('success','操作成功，我们会与您联系！');
					$this->redirect(Yii::app()->createUrl('tender/debt/debtDetail',array('id'=>$id)));

				}
			}
		}
	}
}

?>