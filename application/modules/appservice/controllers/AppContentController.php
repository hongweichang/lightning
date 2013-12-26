<?php
/**
 * @name AppContentController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-27 
 * Encoding UTF-8
 */
class AppContentController extends Controller{
	public function noneLoginRequired(){
		return 'getBanner';
	}
	
	public function actionGetBanner(){
		$content = $this->app->getModule('content')->getComponent('contentManager');
		
		$banner = $content->getInUsingBanner(1);
		if ( $banner === null ){
			$this->response(200,'ok',null);
		}
		
		$file = json_decode($banner->file_names,true);
		
		$this->response(200,'ok',array(
				'title' => $file[0]['title'],
				'url' => $this->app->getPartedUrl('appBanner',$banner->add_time).$file[0]['filename'],
				'content' => $banner->description
		));
	}
}