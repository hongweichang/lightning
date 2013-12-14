<?php
/**
 * @name adBannerEnableAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-14 
 * Encoding UTF-8
 */
class adBannerEnableAction extends CmsAction{
	public function run(){
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('administrator/view')));
		$id = $this->getQuery('id',null);
		$controller = $this->getController();
		if ( $id === null ){
			$controller->showMessage('操作失败，banner不存在',$redirect,false);
		}
		
		$result = $controller->getContentManager()->enableBanner($id,0);
		
		if ( $result === true ){
			$controller->showMessage('操作成功',$redirect,false);
		}elseif ( $result === null ){
			$controller->showMessage('操作失败，banner不存在',$redirect,false);
		}else {
			$controller->showMessage('操作失败，未知错误',$redirect,false);
		}
	}
}