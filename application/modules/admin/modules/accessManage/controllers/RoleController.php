<?php
/**
 * @name RoleController.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-4
 * Encoding UTF-8
 */
class RoleController extends Admin{
	public $defaultAction = 'view';
	public $actionClassPathAlias = 'accessManage.controllers';
	
	public function getActionClass(){
		return array(
				'add',
				'view',
				'edit',
				'delete'
		);
	}
	
	public function getFormConfig($model){
		$items = array(
				0 => '作为一级角色'
		);
		$levelOne = $model->findChildrenByLevel(1);
		foreach ( $levelOne as $i => $level ){
			$children = $model->findChildrenInPreorder($level);
			foreach ( $children as $child ){
				$record = $child['record'];
				$items[$record->getPrimaryKey()] = $record->role_name;
			}
			$children = null;
		}
	
		return array(
				'elements' => array(
						'fid' => array(
								'type' => 'dropdownlist',
								'items' => $items,
								'label' => '上级角色',
								'class' => 'form-input-dropdownlist',
						),
						'role_name' => array(
								'type' => 'text',
								'label' => '角色名称',
								'class' => 'form-input-text',
						),
						'description' => array(
								'type' => 'text',
								'label' => '描述',
								'class' => 'form-input-text',
								'placeholder' => '可不填写',
								'required' => false
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