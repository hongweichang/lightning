<?php
/**
 * @name ContentManager.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-12 
 * Encoding UTF-8
 */
class ContentManager extends CApplicationComponent{
	public function getCategoryProvider($config,$enablePagination=true,$enableSort=true){
		Utils::resovleProviderConfigCriteria($config,$enablePagination,$enableSort);
		return new CActiveDataProvider('ArticleCategory',$config);
	}
	
	public function saveCategory($data){
		$form = new CategoryForm();
		if ( $data === null ){
			return $form;
		}
		$form->attributes = $data;
		if ( $form->save() ){
			return true;
		}else {
			return $form;
		}
	}
	
	public function updateCategory($id,$data){
		$form = new CategoryForm();
		$form->id = $id;
		$form->loadModelData();
		
		if ( $data === null ){
			return $form;
		}
		
		$form->attributes = $data;
		if ( $form->validate() && $form->update() ){
			return true;
		}
		return $form;
	}
	
	public function deleteCategory($id,$condition='',$params=array()){
		return ArticleCategory::model()->deleteByPk($id,$condition,$params);
	}
	
	public function getArticleProvider($config,$type=null,$category=null,$enablePagination=true,$enableSort=true){
		Utils::resovleProviderConfigCriteria($config,$enablePagination,$enableSort);
		$criteria = $config['criteria'];
		$countCriteria = $config['countCriteria'];
		
		if ( $type !== null ){
			$criteria->addCondition('art_type=:type');
			$criteria->params[':type'] = $type;
			$countCriteria->addCondition('art_type=:type');
			$countCriteria->params[':type'] = $criteria->params[':type'];
		}
		if ( $category !== null ){
			$criteria->addCondition('category=:category');
			$criteria->params[':category'] = $category;
			$countCriteria->addCondition('category=:category');
			$countCriteria->params[':category'] = $criteria->params[':category'];
		}
		
		return new CActiveDataProvider('Article',$config);
	}
	
	public function saveArticle($data,$type){
		$form = new ArticleForm();
		$form->loadAllCategories();
		if ( $data === null ){
			return $form;
		}
		$data['art_type'] = $type;
		$data['add_time'] = time();
		$data['admin_name'] = Yii::app()->getUser()->getName();
		$form->attributes = $data;
		if ( $form->validate() && $form->save() ){
			return true;
		}else {
			return $form;
		}
	}
	
	public function updateArticle($id,$data){
		$form = new ArticleForm();
		$form->id = $id;
		$form->loadAllCategories();
		$form->loadModelData();
		
		if ( $data === null ){
			return $form;
		}
		
		$form->attributes = $data;
		if ( $form->validate() && $form->update() ){
			return true;
		}
		return $form;
	}
	
	public function deleteArticle($id,$condition='',$params=array()){
		return Article::model()->deleteByPk($id,$condition,$params);
	}
}