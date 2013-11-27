<?php
/**
 * @name LightningUser.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-24 
 * Encoding UTF-8
 */
class LightningUser extends AuthUser{
	public $avatarPath;
	/**
	 * 每有1000个用户，则将头像分为一个文件夹
	 * @var string
	 */
	public $avatarPartitionSize = 1000;
	
	/**
	 * 解决头像分区，线性hash
	 * @param int $userId
	 * @return string
	 */
	public function resovleAvatarPartition($userId){
		return md5(intval($userId/$this->avatarPartitionSize));
	}
	
	/**
	 * 生成头像名称
	 * @param int $userId
	 * @return string
	 */
	public function generateAvatarFIleName($userId){
		return md5($userId.time());
	}
	
	/**
	 * 获取头像磁盘地址
	 * @param int $userId
	 * @return string
	 */
	public function getAvatarPath($userId){
		return Yii::app()->getBasePath().DS.$this->avatarPath.DS.$this->resovleAvatarPartition($userId).DS;
	}
	
	/**
	 * 获取头像网址
	 * @param int $userId
	 * @return string
	 */
	public function getAvatarUrl($userId){
		return Yii::app()->getHomeUrl().$this->avatarPath.$this->resovleAvatarPartition($userId).'/';
	}
	
	protected function beforeLogin($id, $states, $fromCookie){
		if ( parent::beforeLogin($id, $states, $fromCookie) ){
			$criteria = new CDbCriteria();
			$model = FrontUser::model()->findByPk($id,$criteria);
			$this->setState('email_passed',$model->getAttribute('email_passed'));
			$this->setState('email_verify_code',$model->getAttribute('email_verify_code'));
			$this->setState('mobile_passed',$model->getAttribute('mobile_passed'));
			$this->setState('mobile_verify_code',$model->getAttribute('mobile_verify_code'));
			
			$criteria->select = 'file_name';
			$criteria->condition = 'in_using=1';
			$icons = $model->getRelated('icons',false,$criteria);
			$avatar = null;
			if ( !empty($icons) ){
				$avatar = $this->getAvatarUrl($id).$icons[0]->getAttribute('file_name');
			}
			$this->setState('avatar',$avatar);
			
			$model->setAttributes(array(
				'last_login_time' => time(),
				'last_login_ip' => Yii::app()->request->getUserHostAddress()
			));
			$model->update();
			
			return true;
		}else {
			return false;
		}
	}
}