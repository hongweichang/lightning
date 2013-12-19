<?php
/**
 * @name ArticleFaqReplyForm.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-16 
 * Encoding UTF-8
 */
class ArticleFaqReplyForm extends CFormModel{
	public $id;
	public $title;
	public $content;
	public $user_id;
	public $type;
	
	public function rules(){
		return array(
				array('id,content,user_id','required','message'=>'请填写{attribute}'),
				array('title,type','safe')
		);
	}
	
	public function save(){
		$model = new ArticleFaq();
		$data = array(
				'fid' => $this->id,
				'title' => $this->title,
				'content' => $this->content,
				'user_id' => $this->user_id,
				'faq_type' => $this->type + 1,
				'add_time' => time(),
				'add_ip' => Yii::app()->getRequest()->getUserHostAddress()
		);
		
		$model->attributes = $data;
		if ( $model->save() ){
			return true;
		}else {
			$this->addErrors($model->getErrors());
		}
	}
}