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
				$allData = $cache->get('USER_CREDIT_LEVEL_SETTING');
				if ( $allData === false ){
					$allData = (array)CreditGradeSettings::model()->findAll();
				}
			}else {
				$allData = (array)CreditGradeSettings::model()->findAll();
			}
			
			if ( $cache !== null ){
				$cache->set('USER_CREDIT_LEVEL_SETTING',$allData,24*3600);
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

	/*
	**获取用户各项操作利率接口
	*/
	public function UserRateGet($uid){
		if(is_numeric($uid)){
			$userCreditLevel = $this->getUserCreditLevel($uid);
			$rate = array();

			if(!empty($userCreditLevel)){
				$userRate = CreditGradeSettings::model()->findAll('label=:level',array(':level'=>$userCreditLevel));
				$rate = array(
						'on_recharge'=>$userRate[0]->on_recharge/100,
						'on_withdraw'=>$userRate[0]->on_withdraw/100,
						'on_pay_back'=>$userRate[0]->on_pay_back/100,
						'on_over6'=>$userRate[0]->on_over6/100,
						'on_blow6'=>$userRate[0]->on_below6/100

							);
				return $rate;


			}else
				return 400;
		}
	}

	/*
	**获取会员级别列表
	*/

	public function UserLevelList(){
		$levelData = CreditGradeSettings::model()->findAll();
		if(!empty($levelData)){
			return $levelData;
		}

	}
}

	
?>