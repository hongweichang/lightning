<?php
/**
 * @name adBannerAddAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-13 
 * Encoding UTF-8
 */
class adBannerAddAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$controller->addToSubtab('banner方案列表','content/adBanner');
		$controller->tabTitle = '添加banner方案';
		$controller->addNotifications('推荐上传2000 x 400 尺寸的图片，否则可能会出现图片拉伸失真现象');
		
		$data = $this->getPost('BannerSchemeForm');
		$form = $controller->getContentManager()->saveBanner($data,0);
		if ( $form === true ){
			$controller->showMessage('添加成功','content/adBanner');
		}
		
		$this->render('adBannerForm',array('model'=>$form,'action'=>$this->createUrl('content/adBannerAdd') ) );
	}
}