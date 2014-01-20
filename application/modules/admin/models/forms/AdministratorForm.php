<?php
/**
 * @name AdministratorForm.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-10 
 * Encoding UTF-8
 */
class AdministratorForm extends CFormModel{
	public $model;
	public $nickname;
	public $account;
	public $password;
	public $roles;
	public $allRoles;
	
	public function loadRoles($userId=null){
		if ( $userId === null ){
			$this->roles = array();
			$this->allRoles = array();
		}
		$app = Yii::app();
		$userRoles = $app->getAuthManager()->getCalculator()->findUserRoles($userId);
		$this->roles = array();
		foreach ( $userRoles as $r ){
			$this->roles[] = $r->primaryKey;
		}
		
		$model = $app->getAuthManager()->getItemModel(AuthManager::ROLE,false);
		$levelOne = $model->findChildrenByLevel(1);
		foreach ( $levelOne as $i => $level ){
			$children = $model->findChildrenInPreorder($level);
			foreach ( $children as $child ){
				$record = $child['record'];
				$this->allRoles[$record->getPrimaryKey()] = $record->role_name;
			}
			$children = null;
		}
	}
	
	public function refreshRoles($userId){
		$app = Yii::app();
		$assigner = $app->getAuthManager()->getAssigner();
		$assigner->clear(AuthAssigner::ITEM_ROLE,AuthAssigner::ITEM_USER,'user_id=:u',array(':u'=>$userId));
		$data = array();
		if ( empty($this->roles) ){
			$this->roles = array();
		}
		foreach ( $this->roles as $value ){
			$data[] = array('user_id'=>$userId,'role_id'=>$value);
		}
		$assigner->grant(AuthAssigner::ITEM_ROLE,$data)->to(AuthAssigner::ITEM_USER)->doit();
	}
	
	public function rules(){
		return array(
				array('nickname,account','required','message'=>'请填写{attribute}'),
				array('password,roles,model','safe')
		);
	}
	
	public function attributeLabels(){
		return array(
				'nickname' => '昵称',
				'account' => '帐号',
				'password' => '密码',
				'roles' => '角色'
		);
	}
	
	public function save(){
		if ( $this->validate() ){
			$model = new Administrators();
			$attributes = $this->attributes;
			$attributes['user_type'] = 'backend';
			$model->attributes = $attributes;
			if ( $model->validate() ){
				$model->save(false);
				$this->refreshRoles($model->id);
				return true;
			}else {
				$this->addErrors($model->getErrors());
			}
		}
		return false;
		
	}
	
	public function update(){
		$attributes = $this->attributes;
		if ( isset($attributes['password']) && empty($attributes['password']) ){
			unset($attributes['password']);
		}
		
		$this->model->attributes = $attributes;
		if ( $this->validate() === false ){
			return false;
		}
		
		if ( $this->model->validate() ){
			if ( isset($attributes['password']) ){
				$this->model->setPassword($attributes['password']);
			}
			$this->model->save(false);
			$this->refreshRoles($this->model->id);
			return true;
		}else {
			$this->addErrors($this->model->getErrors());
			return false;
		}
	}
}