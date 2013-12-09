<?php
/**
 * @name viewAction.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-5
 * Encoding UTF-8
 */
class viewAction extends CmsAction{
	public function run(){
		$model = $this->app->getAuthManager()->getItemModel(AuthManager::GROUP);
		$data = array();
		
		$criteria = new CDbCriteria();
		$count = $model->count();
		$pager = new CPagination($count);
		$pager->pageSize = 30;
		$pager->applyLimit($criteria);
		$data = $model->findAll($criteria);
		
		$this->getController()->addToSubNav('添加用户组','group/add');
		$this->setPageTitle('用户组管理');
		$this->render('view',array('list' => $data,'pager'=>$pager));
	}
}