<?php
/**
 * @name ArticleForm.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-12 
 * Encoding UTF-8
 */
class ArticleForm extends CFormModel{
	public $id;
	public $title;
	public $content;
	public $admin_name;
	public $add_time;
	public $category = 0;
	public $allCategories = array();
	public $modelExists = false;
	
	public function rules(){
		return array(
				array('title,content,admin_name,add_time','required','message'=>'请填写{attribute}'),
				array('category','select'),
				array('id','safe')
		);
	}
	
	public function attributeLabels(){
		return array(
				'id' => '文章/官方宝典',
				'title' => '标题',
				'content' => '内容',
				'admin_name' => '管理员昵称',
				'add_time' => '添加时间',
				'category' => '分类',
		);
	}
	
	public function save(){
		$model = new Article();
		$model->attributes = $this->attributes;
		if ( $model->save() ){
			return true;
		}else {
			$this->addErrors($model->getErrors());
			return false;
		}
	}
	
	public function update(){
		$model = Article::model()->findByPk($this->id);
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
	
	public function loadAllCategories($type){
		$model = new ArticleCategory();
		$all = $model->findAll('fid=:type',array(':type'=>$type));
		var_dump($all);die;
		$this->allCategories[0] = '请选择分类';
		foreach ( $all as $data ){
			$this->allCategories[$data->id] = $data->category_name;
		}
	}
	
	//validator
	public function select($attribute){
		if ( $this->category == 0 ){
			$this->addError('category','请选择分类');
		}
	}
	
	public function loadModelData(){
		$model = Article::model()->findByPk($this->id);
		if ( $model !== null ){
			$this->modelExists = true;
			$this->attributes = $model->attributes;
		}
	}
}