<?php
/**
 * @name ConEnv.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-28 
 * Encoding UTF-8
 */
class ConEnv extends ConsoleEnv{
	public function beforeRun(){
		Yii::import('cms.components.CmsApplication',true);
		require dirname(__FILE__).DS.'../components/ConsoleApp.php';
		return true;
	}
}