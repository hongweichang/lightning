<?php
/**
 * @name GroupController.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-5
 * Encoding UTF-8
 */
class GroupController extends Admin{
	public $actionClassPathAlias = 'accessManage.controllers';
	
	public function getActionClass(){
		return array(
				'add',
				'edit',
				'view',
				'delete'
		);
	}
	
	public function getFormConfig(){
		return array(
				'elements' => array(
						'group_name' => array(
								'type' => 'text',
								'label' => '用户组名称',
								'class' => 'form-input-text',
						),
						'description' => array(
								'type' => 'text',
								'label' => '用户组描述',
								'class' => 'form-input-text',
						)
				),
				'buttons' => array(
						'submit' => array(
								'type' => 'submit',
								'label' => '确定',
								'class' => 'form-button form-button-submit'
						)
				)
		);
	}
}