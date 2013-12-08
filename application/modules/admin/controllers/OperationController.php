<?php
/**
 * @name OperationController.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-2
 * Encoding UTF-8
 */
class OperationController extends Admin{
	public $defaultAction = 'view';
	
	public function noneLoginRequired(){
		return 'add,view,edit,delete,scan';
	}
	
	
	
	public function actionAdd(){
		$model = $this->app->getAuthManager()->getItemModel(AuthManager::OPERATION);
		
		$className = get_class($model);
		$post = $this->getPost($className,null);
		if ( $post !== null ){
			$model->attributes = $post;
				
			if ( $model->save() ){
				$assigner = $this->app->getAuthManager()->getAssigner();
				$assignData = array(
						'operation_id' => $model->primaryKey,
						'permission_name' => $model->operation_name,
						'description' => $model->description
				);
				$assigner->grant(AuthAssigner::ITEM_OPERATION,$assignData)->to(AuthAssigner::ITEM_PERMISSION)->doit();
				//$this->getController()->showMessage('添加成功','operation/view');
			}
		}
		
		$formConfig = $this->getFormConfig($model);
		
		$form = new CForm($formConfig,$model);
		$this->setPageTitle('添加操作');
		
		$this->render('add',array('form'=>$form));
	}
	
	/**
	 *
	 * @param AuthOperation $model
	 */
	public function getFormConfig($model){
		$items = array(
				0 => '作为一级操作'
		);
		$levelOne = $model->findChildrenByLevel(1);
		foreach ( $levelOne as $i => $level ){
			$children = $model->findChildrenInPreorder($level);
			foreach ( $children as $child ){
				$record = $child['record'];
				$parentKey = $child['parent'];
				if ( $record->level > 2 ){
					continue;
				}
				if ( $child['parent'] === null ){
					$items[$record->getPrimaryKey()] = $record->operation_name;
					continue;
				}
				prev($children);
				$p = prev($children);
				if ( $p === false ){
					$prev = reset($children);
				}else {
					$prev = $p;
					next($children);
				}
				$next = next($children);
				if ( $p !== false && ($prev['parent'] === null || ($prev['parent'] === $parentKey && $next !== false && $next['parent'] === $parentKey) ) ){
					$prefix = ' ├─ ';
				}else {
					$prefix = ' └─ ';
				}
				$items[$record->getPrimaryKey()] = $prefix.$record->operation_name;
				if ( $next !== false ){
					prev($children);
				}
			}
			$children = null;
		}
		
		return array(
				'elements' => array(
						'fid' => array(
								'type' => 'dropdownlist',
								'items' => $items,
								'label' => '上级操作',
								'class' => 'form-input-dropdownlist',
						),
						'operation_name' => array(
								'type' => 'text',
								'label' => '操作名称',
								'class' => 'form-input-text',
						),
						'module' => array(
								'type' => 'text',
								'label' => '模块名称',
								'class' => 'form-input-text',
								'required' => false
						),
						'controller' => array(
								'type' => 'text',
								'label' => '控制器名',
								'class' => 'form-input-text',
						),
						'action' => array(
								'type' => 'text',
								'label' => '动作名称',
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