<?php
/**
 * @name appAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-15 
 * Encoding UTF-8
 */
class appAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$controller->tabTitle = 'app动态配置方案';
		$controller->addToSubTab('app动态配置方案','content/appAdd');
		$controller->addNotifications('app动态配置方案只能启用一个<br>您可以通过配置并启用不同的配置方案来控制app展示');
		
		$dataProvider = $controller->bannerList(1);
		$this->render('app',array('dataProvider'=>$dataProvider));
	}
}