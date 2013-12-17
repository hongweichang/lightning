<?php
/**
 * @name adBannerDetailAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-14 
 * Encoding UTF-8
 */
class adBannerDetailAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		
		$controller->addToSubTab('广告banner列表','content/adBanner');
		$controller->addToSubTab('添加广告banner','content/adBannerAdd');
		
		$controller->bannerDetail(0,'adBannerDetail');
	}
}