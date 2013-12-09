<?php
/**
 * @name roleAction.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-5
 * Encoding UTF-8
 */
class roleAction extends CmsAction{
	public function run(){
		$userId = $this->getQuery('user',null);
		if ( $userId === null ){
			$this->redirect($this->request->urlReferrer);
		}
		
		$submit = $this->getPost('submit',null);
		if ( $submit !== null ){
			$values = $this->getPost('value',array());
			$assigner = $this->app->getAuthManager()->getAssigner();
			$assigner->clear(AuthAssigner::ITEM_ROLE,AuthAssigner::ITEM_USER,'user_id=:u',array(':u'=>$userId));
			foreach ( $values as $value ){
				$assigner->grant(AuthAssigner::ITEM_ROLE,array('user_id'=>$userId,'role_id'=>$value))
				->to(AuthAssigner::ITEM_USER)->doit();
			}
			$this->getController()->showMessage('授权成功','/sqbadmin/user/view');
		}
		
		$userRoles = $this->app->getAuthManager()->getCalculator()->findUserRoles($userId);
		$existRoles = array();
		foreach ( $userRoles as $r ){
			$existRoles[] = $r->primaryKey;
		}
		
		$model = $this->app->getAuthManager()->getItemModel(AuthManager::ROLE,false);
		$levelOne = $model->findChildrenByLevel(1);
		foreach ( $levelOne as $i => $level ){
			$children = $model->findChildrenInPreorder($level);
			foreach ( $children as $child ){
				$record = $child['record'];
				$items[$record->getPrimaryKey()] = $record->role_name;
			}
			$children = null;
		}
		
		$this->pageTitle = '角色授权';
		$this->render('role',array('userRoles'=>$existRoles,'items'=>$items,'userId'=>$userId));
	}
}