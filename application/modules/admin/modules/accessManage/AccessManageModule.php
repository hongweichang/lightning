<?php
/**
 * @name AccessManageModule.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-2
 * Encoding UTF-8
 */
class AccessManageModule extends CmsModule{
	public function init(){
		Yii::import('accessManage.components.*');
		Yii::import('accessManage.controllers.*');
	}
}