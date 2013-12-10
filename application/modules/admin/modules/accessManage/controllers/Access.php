<?php
/**
 * @name Access.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-9 
 * Encoding UTF-8
 */
class Access extends Admin{
	public $layout='right';
	public $subNavs = array();
	
	public function init(){
		parent::init();
		$app = $this->app;
		$app->setPath('js','UED/backend2/javascript/');
		$app->setPath('css','UED/backend2/css/');
		$app->setPath('image','UED/backend2/images/');
		
		$this->cssUrl = $this->app->getPartedUrl('css');
		$this->scriptUrl = $this->app->getPartedUrl('js');
		$this->imageUrl = $this->app->getPartedUrl('image');
	}
	
	public function loginRequired(){
		$this->redirect($this->createUrl('/'.$this->getModule()->getParentModule()->id));
	}
	
	public function showMessage($message,$redirectUrl='',$wait=5,$terminate=true){
		$url = $this->createUrl($redirectUrl);
		$this->renderPartial('/common/flashMessage',array(
				'waitSeconds' => $wait,
				'jumpUrl' => $url,
				'msg' => $message
		));
		if ( $terminate === true ){
			$this->app->end();
		}
	}
	
	public function addToSubNav($text,$route,$title='',$urlParams=array()){
		$html = $this->renderPartial('/common/subNavButton',array('text'=>$text,'url'=>$this->createUrl($route,$urlParams),'title'=>$title),true);
		$this->subNavs[] = $html;
	}
}