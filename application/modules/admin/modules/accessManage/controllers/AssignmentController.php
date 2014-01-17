<?php
/**
 * @name AssignmentController.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-5
 * Encoding UTF-8
 */
class AssignmentController extends Access{
	public $actionClassPathAlias = 'accessManage.controllers';
	
	public function getActionClass(){
		return array(
				'permission',
				'role',
				'groupRole',
				'groupUser'
		);
	}
	
	public function actionIndex(){
		$this->pageTitle = '授权管理';
		$this->addToSubNav('为角色授权','/sqbadmin/user/view','将角色授予给用户');
		$this->addToSubNav('用户组授权','/sqbadmin/user/view','将用户组授予给用户');
		$this->addToSubNav('用户组角色授权','group/view','将角色授予用户组');
		$this->addToSubNav('操作授权','role/view','将操作授予给角色');
		$this->render('index');
	}
}