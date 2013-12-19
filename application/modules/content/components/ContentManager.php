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
	
	public function getBannerProvider($config,$type=null,$enablePagination=true,$enableSort=true){
		Utils::resovleProviderConfigCriteria($config,$enablePagination,$enableSort);
		$criteria = $config['criteria'];
		$countCriteria = $config['countCriteria'];
		
		if ( $type !== null ){
			$criteria->addCondition('banner_type=:type');
			$criteria->params[':type'] = $type;
			$countCriteria->addCondition('banner_type=:type');
			$countCriteria->params[':type'] = $criteria->params[':type'];
		}
		
		return new CActiveDataProvider('BannerScheme',$config);
	}
	
	public function saveBanner($data,$type){
		$form = new BannerSchemeForm();
		if ( $data === null ){
			return $form;
		}
		
		$data['banner_type'] = $type;
		$form->attributes = $data;
		if ( $form->validate() && $form->save() ){
			return true;
		}else {
			return $form;
		}
	}
	
	public function enableBanner($id,$type){
		$model = BannerScheme::model();
		$banner = $model->findByPk($id);
		if ( $banner === null ){
			return null;
		}
		
		$exist = $model->find('is_using=1 AND banner_type=:type',array(':type'=>$type));
		if ( $exist !== null ){
			$exist->is_using = $exist->is_using ^ 1;
			$exist->update();
		}
		
		$isUsing = $banner->is_using;
		$banner->is_using = $isUsing ^ 1;
		return $banner->update();
	}
	
	public function getInUsingBanner($type){
		$provider = $this->getBannerProvider(array(
				'criteria' => array(
						'condition' => 'is_using=1',
				)
		),$type,false,false);
		$data = $provider->getData();
		if ( empty($data) ){
			return null;
		}else {
			return $data[0];
		}
	}
	
	public function getFaqProvider($config,$type=null,$withUser=true,$enablePagination=true,$enableSort=true){
		Utils::resovleProviderConfigCriteria($config,$enablePagination,$enableSort);
		$criteria = $config['criteria'];
		$countCriteria = $config['countCriteria'];
		
		if ( $type !== null ){
			$criteria->addCondition('faq_type=:type');
			$criteria->params[':type'] = $type;
			$countCriteria->addCondition('faq_type=:type');
			$countCriteria->params[':type'] = $criteria->params[':type'];
		}
		
		if ( $withUser === true ){
			if ( $type === 0 || $type === 2 ){
				$criteria->with[] = 'publisher';
			}elseif ( $type === 1 || $type === 3 ){
				$criteria->with[] = 'replier';
			}
		}
		
		return new CActiveDataProvider('ArticleFaq',$config);
	}
	
	public function replyFaq($id,$data,$type){
		$form = new ArticleFaqReplyForm();
		if ( $data === null || $id === null || $type === null ){
			return $form;
		}
		
		$data['id'] = $id;
		$data['type'] = $type;
		$data['user_id'] = Yii::app()->getUser()->getId();
		
		$form->attributes = $data;
		if ( $form->validate() && $form->save() ){
			return true;
		}else {
			return $form;
		}
	}
	
	public function deleteFaq($id){
		return ArticleFaq::model()->deleteAll('id=:id OR fid=:id',array(':id'=>$id));
	}
}