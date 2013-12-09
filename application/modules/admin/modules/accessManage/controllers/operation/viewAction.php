<?php
/**
 * @name viewAction.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-3
 * Encoding UTF-8
 */
class viewAction extends CmsAction{
	public function run(){
		$model = $this->app->getAuthManager()->getItemModel(AuthManager::OPERATION);
		$data = array();
		
		$levelOne = $model->findChildrenByLevel(1);
		foreach ( $levelOne as $i => $level ){
			$data[$i]['parent'] = $level;
			$data[$i]['children'] = array();
			$levelTwo = $model->findChildrenByParent($level);
			foreach ( $levelTwo as $j => $levelT ){
				$data[$i]['children'][$j]['parent'] = $levelT;
				$data[$i]['children'][$j]['children'] = array();
				$levelThree = $model->findChildrenByParent($levelT);
				foreach ( $levelThree as $levelTh ){
					$data[$i]['children'][$j]['children'][] = $levelTh;
				}
			}
		}
		
		$this->getController()->registerTreePlugin();
		$this->getController()->addToSubNav('添加操作','operation/add');
		$this->getController()->addToSubNav('自动扫描','operation/scan');
		$this->setPageTitle('操作管理');
		$this->render('view',array('list' => $data));
	}
}