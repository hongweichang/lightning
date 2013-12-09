<?php
/**
 * @name groupRoleAction.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-5
 * Encoding UTF-8
 * 
 * 将角色授予用户组
 */
class groupRoleAction extends CmsAction{
	public function run(){
		$groupId = $this->getQuery('group',null);
		if ( $groupId === null ){
			$this->redirect($this->request->urlReferrer);
		}
		
		$submit = $this->getPost('submit',null);
		if ( $submit !== null ){
			$values = $this->getPost('value',array());
			$assigner = $this->app->getAuthManager()->getAssigner();
			$assigner->clear(AuthAssigner::ITEM_ROLE,AuthAssigner::ITEM_GROUP,'group_id=:g',array(':g'=>$groupId));
			foreach ( $values as $value ){
				$assigner->grant(AuthAssigner::ITEM_ROLE,array('group_id'=>$groupId,'role_id'=>$value))
				->to(AuthAssigner::ITEM_GROUP)->doit();
			}
			$this->getController()->showMessage('授权成功','group/view');
		}
		
		$groupRoles = $this->app->getAuthManager()->getCalculator()->findGroupRoles($groupId);
		$existRoles = array();
		foreach ( $groupRoles as $r ){
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
		
		$this->pageTitle = '用户组角色授权';
		$this->render('groupRole',array('groupRoles'=>$existRoles,'items'=>$items,'groupId'=>$groupId));
	}
}