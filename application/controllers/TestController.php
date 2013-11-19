<?php
/**
 * @name TestController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-14 
 * Encoding UTF-8
 */
class TestController extends CmsController{
<<<<<<< HEAD
	public function filters(){
		return array();
	}
=======

	public function filters(){
		return array();
	}
	
>>>>>>> tmp
	public function actionIndex(){
		echo 'succed';
		$extension = 'exe';
		
		$map = array(
				'file' => 'jpg|jpeg|gif'
		);
		
		foreach ( $map as $type => $ext ){
			if ( preg_match($ext,$extension) ){
				$type;
			}else {
				continue;
			}
		}
		
		echo 'error';
	}
	
	public function actionCache(){
		$cache = $this->app->cache;
		$data = $cache->get('testMemCache');
		if ( $data === false ){
			echo 'setting cache';
			$cache->set('testMemCache','yes');
		}else {
			echo 'got cache';
			echo $data;
		}
	}
}