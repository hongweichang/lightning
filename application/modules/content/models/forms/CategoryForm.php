<?php
/**
 * @name CategoryForm.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-12 
 * Encoding UTF-8
 */
class CategoryForm extends CFormModel{
	public $id;
	public $category_name;
	public $description;
	public $modelExists = false;
	
	public function rules(){
		return array(
				array('category_name','required','message'=>'请输入分类名称'),
				array('description,id','safe')
		);
	}
	
	public function attributeLabels(){
		return array(
				'id' => '分类',
				'category_name' => '分类名称',
				'description' => '描述'
		);
	}
	
	public function save(){
		$model = new ArticleCategory();
		$model->attributes = $this->attributes;
		if ( $model->validate() ){
			return $model->save(false);
		}else {
			$this->addErrors($model->getErrors());
			return false;
		}
	}
	
	public function update(){
		$model = ArticleCategory::model()->findByPk($this->id);
		if ( $model === null ){
			return false;
		}
		$model->attributes = $this->attributes;
		
		if ( $model->validate() ){
			return $model->save(false);
		}else {
			$this->addErrors($model->getErrors());
			return false;
		}
	}
	
	public function loadModelData(){
		$model = ArticleCategory::model()->findByPk($this->id);
		if ( $model !== null ){
			$this->modelExists = true;
			$this->attributes = $model->attributes;
		}
	}
}