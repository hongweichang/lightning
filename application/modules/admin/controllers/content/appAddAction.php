<?php
/**
 * @name appAddAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-15 
 * Encoding UTF-8
 */
class appAddAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$controller->addToSubtab('app动态配置方案列表','content/app');
		$controller->tabTitle = '添加app动态配置方案';
		//$controller->addNotifications('推荐上传2000 x 400 尺寸的图片，否则可能会出现图片拉伸失真现象');
		
		$form = $controller->bannerAdd(1);
		if ( $form === true ){
			$controller->showMessage('添加成功','content/app');
		}
		
		$this->render('appForm',array('model'=>$form,'action'=>$this->createUrl('content/appAdd') ) );
	}
}