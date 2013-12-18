<?php
/**
 * @name adBannerAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-13 
 * Encoding UTF-8
 */
class adBannerAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$controller->tabTitle = '广告banner配置方案';
		$controller->addToSubTab('添加配置方案','content/adBannerAdd');
		$controller->addNotifications('广告banner配置方案只能启用一个<br>您可以通过配置并启用不同的banner配置方案来控制首页banner展示');
		
		$dataProvider = $controller->bannerList(0);
		$this->render('adBanner',array('dataProvider'=>$dataProvider));
	}
}