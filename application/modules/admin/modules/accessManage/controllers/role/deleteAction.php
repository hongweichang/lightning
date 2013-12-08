<?php
/**
 * @name deleteAction.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-4
 * Encoding UTF-8
 */
class deleteAction extends CmsAction{
public function run(){
		$id = $this->getQuery('id',null);
		
		if ( $id === null )
			$this->redirect($this->createUrl('role/view'));
		
		$this->app->getAuthManager()->removeItem(AuthManager::ROLE,$id);
		
		$this->redirect($this->createUrl('role/view'));
	}
}