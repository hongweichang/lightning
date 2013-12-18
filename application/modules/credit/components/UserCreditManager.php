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

	public function UserLevelCaculator($point){
		if(is_numeric($point)){
			$cache = Yii::app()->getCache();
			if ( $cache !== null ){
				$allData = $cache->get('USER_CREDIT_LEVEL_SETTINGS');
				if ( $allData === false ){
					$allData = (array)CreditGradeSettings::model()->findAll();
				}
			}else {
				$allData = (array)CreditGradeSettings::model()->findAll();
			}
			
			if ( $cache !== null ){
				$cache->set('USER_CREDIT_LEVEL_SETTINGS',$allData,24*3600);
			}
			
			$label = null;
			foreach ( $allData as $data ){
				if ( $point >= $data['start'] ){
					$label = $data['label'];
					break;
				}
			}
			
			return $label;
		}else
			return 401;
	}
}

	
?>