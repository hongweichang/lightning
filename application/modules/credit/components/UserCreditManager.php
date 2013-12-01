<?php
/*
**信息处理工具包
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/
class UserCreditManager extends CApplicationComponent{
	public function getUserCreditLevel($uid){
		if(!empty($uid) && is_numeric($uid)){

			$userCredit = FrontUser::model()->findByPk($uid);
			if(!empty($userCredit)){
				$userCreditPoint = $userCredit['attributes']['credit_grade'];
				$userLevel = $this->UserLevelCaculator($userCreditPoint);
				return $userLevel;
			}

		}
	}

	public function UserLevelCaculator($Point){
		if(is_numeric($Point)){
			if('0' <= $Point && $Point <= '99' )
				return 'HR';
			elseif('100' <= $Point && $Point <= '109')
				return 'E';
			elseif('110' <= $Point && $Point <= '119')
				return 'D';
			elseif('120' <= $Point && $Point <= '129')
				return 'C';
			elseif('130' <= $Point && $Point <= '144')
				return 'B';
			elseif('145' <= $Point && $Point <= '159')
				return 'A';
			elseif($Point >= '160')
				return 'AA';
			else
				return 400;

		}else
			return 401;
	}
}

	
?>