<?php
/**
 * @name operationAction.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-5
 * Encoding UTF-8
 */
class permissionAction extends CmsAction{
	public function run(){
		$roleId = $this->getQuery('role',null);
		if ( $roleId === null ){
			$this->redirect($this->request->urlReferrer);
		}
		
		$submit = $this->getPost('submit',null);
		if ( $submit !== null ){
			$values = $this->getPost('value',array());
			$assigner = $this->app->getAuthManager()->getAssigner();
			$assigner->clear(AuthAssigner::ITEM_PERMISSION,AuthAssigner::ITEM_ROLE,'role_id=:r',array(':r'=>$roleId));
			foreach ( $values as $value ){
				$assigner->grant(AuthAssigner::ITEM_PERMISSION,array('role_id'=>$roleId,'permission_id'=>$value))
				->to(AuthAssigner::ITEM_ROLE)->doit();
			}
			$this->getController()->showMessage('授权成功','role/view');
		}
		
		$model = $this->app->getAuthManager()->getItemModel(AuthManager::OPERATION,false);
		if ( $model === null ){
			$this->redirect($this->request->urlReferrer);
		}
		
		$rolePermissions = $this->app->getAuthManager()->getCalculator()->findRolePermissions($roleId);
		$existPermissions = array();
		foreach ( $rolePermissions as $p ){
			$existPermissions[] = $p->primaryKey;
		}
		
		$withOption = array(
				'with' => array(
						'AuthPermissions'
				)
		);
		$data = array();
		$levelOne = $model->findChildrenByLevel(1,$withOption);
		foreach ( $levelOne as $i => $level ){
			$data[$i]['parent'] = $level->AuthPermissions[0];
			$data[$i]['children'] = array();
			$levelTwo = $model->findChildrenByParent($level,$withOption);
			foreach ( $levelTwo as $j => $levelT ){
				$data[$i]['children'][$j]['parent'] = $levelT->AuthPermissions[0];
				$data[$i]['children'][$j]['children'] = array();
				$levelThree = $model->findChildrenByParent($levelT,$withOption);
				foreach ( $levelThree as $levelTh ){
					$data[$i]['children'][$j]['children'][] = $levelTh->AuthPermissions[0];
				}
			}
		}
		//array('$("#tree").treetable("expandAll")')
		$this->getController()->registerTreePlugin();
		$this->pageTitle = '操作授权';
		$this->render('operation',array('list'=>$data,'rolePermissions'=>$existPermissions,'roleId'=>$roleId));
	}
}