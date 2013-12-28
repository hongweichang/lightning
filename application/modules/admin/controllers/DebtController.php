<?php
/*
**债权模块
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/

class DebtController extends Admin(){
	public function filters(){
		$filters = parent::filters();
		return $filters;	
	}

	public function actionCreateDebt(){
		$model = new Debt;
		$post = $this->getPost();

		if(!empty($post)){
			
			$attributes = $model->attributes;

		}
	}
}
?>