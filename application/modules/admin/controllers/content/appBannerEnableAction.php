<?php
/**
 * @name appBannerEnableAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-27 
 * Encoding UTF-8
 */
class appBannerEnableAction extends CmsAction{
	public function run(){
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('index/welcome')));
		$id = $this->getQuery('id',null);
		$controller = $this->getController();
		if ( $id === null ){
			$controller->showMessage('操作失败，banner不存在',$redirect,false);
		}

		$content = $controller->getContentManager();
		$result = $content->enableBanner($id,1);

		$cache = Yii::app()->getCache();
		if ( $cache !== null ){
			$appBanner = $content->getInUsingBanner(1);
			$cache->set('APP_BANNER',$appBanner,24*3600);
		}

		if ( $result === true ){
			$controller->showMessage('操作成功',$redirect,false);
		}elseif ( $result === null ){
			$controller->showMessage('操作失败，banner不存在',$redirect,false);
		}else {
			$controller->showMessage('操作失败，未知错误',$redirect,false);
		}
	}
}