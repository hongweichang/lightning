<?php
/**
 * @name groupUserAction.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-5
 * Encoding UTF-8
 */
class groupUserAction extends CmsAction{
	public function run(){
		$userId = $this->getQuery('user',null);
		if ( $userId === null ){
			$this->redirect($this->request->urlReferrer);
		}
		
		$submit = $this->getPost('submit',null);
		if ( $submit !== null ){
			$values = $this->getPost('value',array());
			$assigner = $this->app->getAuthManager()->getAssigner();
			$assigner->clear(AuthAssigner::ITEM_GROUP,AuthAssigner::ITEM_USER,'user_id=:u',array(':u'=>$userId));
			foreach ( $values as $value ){
				$assigner->grant(AuthAssigner::ITEM_GROUP,array('user_id'=>$userId,'group_id'=>$value))
				->to(AuthAssigner::ITEM_USER)->doit();
			}
			$this->getController()->showMessage('授权成功','');
		}
		
		$userGroups = $this->app->getAuthManager()->getCalculator()->findUserGroups($userId);
		$existGroups = array();
		foreach ( $userGroups as $u ){
			$existGroups[] = $u->primaryKey;
		}
		
		$model = $this->app->getAuthManager()->getItemModel(AuthManager::GROUP,false);
		$levelOne = $model->findAll();
		foreach ( $levelOne as $level ){
			$items[$level->getPrimaryKey()] = $level->group_name;
		}
		
		$this->pageTitle = '用户组授权';
		$this->render('groupUser',array('userGroups'=>$existGroups,'items'=>$items,'userId'=>$userId));
	}
}