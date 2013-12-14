<?php
/**
 * @name adBannerDetailAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-14 
 * Encoding UTF-8
 */
class adBannerDetailAction extends CmsAction{
	public function run(){
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('administrator/view')));
		$id = $this->getQuery('id',null);
		$controller = $this->getController();
		if ( $id === null ){
			$controller->showMessage('banner不存在',$redirect,false);
		}
		
		$provider = $controller->getContentManager()->getBannerProvider(array(
				'criteria' => array(
						'condition' => 'id=:id',
						'params' => array(
								':id' => $id
						)
				)
		),false,false);
		$data = $provider->getData();
		
		if ( empty($data) ){
			$controller->showMessage('banner不存在',$redirect,false);
		}
		
		$data = $data[0];
		$files = json_decode($data->file_names,true);
		$addTime = $data->add_time;
		foreach ( $files as $i => $file ){
			$files[$i]['filename'] = $this->app->getPartedUrl('siteBanner',$addTime).$file['filename'];
		}
		
		$controller->tabTitle = '广告banner方案-'.$data->scheme_name.' 详情';
		$controller->addToSubTab('banner列表','content/adBanner');
		$controller->addToSubTab('添加banner','content/adBannerAdd');
		$this->render('adBannerDetail',array('model'=>$data,'files'=>&$files));
	}
}