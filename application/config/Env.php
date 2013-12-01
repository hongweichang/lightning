<?php
/**
 * @name Env.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-1 
 * Encoding UTF-8
 */
class Env extends Environment{
	protected function beforeRun(){
		Yii::import('cms.components.CmsApplication',true);
		require dirname(__FILE__).DS.'../components/Application.php';
		return true;
	}
}