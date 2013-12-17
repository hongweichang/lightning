<?php
/*
**信息处理工具包
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/
class UserCreditManager extends CApplicationComponent{
	public function getUserCreditLevel($uid){
		if(!empty($uid) && is_numeric($uid)){
			$level = null;
			
			$userCredit = FrontUser::model()->findByPk($uid);
			if( $userCredit !== null ){
				return $this->UserLevelCaculator($userCredit->credit_grade);
			}else {
				return null;
			}
		}
	}

	public function UserLevelCaculator($Point){
		if(is_numeric($Point)){
			$criteria = new CDbCriteria;
			$criteria->condition = 'start<=:Point';
			$criteria->params = array(
								':Point'=>$Point
							);
			$criteria->order = 'start DESC';
			$criteria->limit = 1;

			$levelData = CreditGradeSettings::model()->findAll($criteria);

			if(!empty($levelData)){
				$levelData[0]->label;
			}else {
				return null;
			}
		}else
			return 401;
	}
}

	
?>