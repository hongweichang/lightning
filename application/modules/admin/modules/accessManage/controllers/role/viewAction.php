<?php
/**
 * @name viewAction.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-4
 * Encoding UTF-8
 */
class viewAction extends CmsAction{
	public function run(){
		$model = $this->app->getAuthManager()->getItemModel(AuthManager::ROLE);
		$data = array();
		
		$levelOne = $model->findChildrenByLevel(1);
		foreach ( $levelOne as $level ){
			$data[] = $level;
			$levelTwo = $model->findChildrenByParent($level);
			foreach ( $levelTwo as $levelT ){
				$data[] = $levelT;
			}
		}
		
		$this->getController()->addToSubNav('添加角色','role/add');
		$this->setPageTitle('角色管理');
		$this->render('view',array('list' => $data));
	}
}