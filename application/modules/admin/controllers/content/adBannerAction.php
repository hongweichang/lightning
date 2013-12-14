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
		$content = $controller->getContentManager();
		
		$dataProvider = $content->getBannerProvider(array(
				'criteria' => array(
						'order' => 'is_using DESC,add_time DESC'
				),
				'pagination' => array(
						'pageSize' => 15
				),
		));
		$data = $dataProvider->getData();
		foreach ( $data as $i => $scheme ){
			$data[$i]->file_names = json_decode($scheme->file_names,true);
		}
		$dataProvider->setData($data);
		
		$this->render('adBanner',array('dataProvider'=>$dataProvider));
	}
}