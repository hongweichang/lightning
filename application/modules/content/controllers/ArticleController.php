<?php
/**
 * @name ArticleController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-20 
 * Encoding UTF-8
 */
class ArticleController extends Controller{
	public $defaultAction = 'view';
	
	public function noneLoginRequired(){
		return 'view';
	}
	
	public function actionView(){
		$id = $this->getQuery('id');
		if ( $id === null ){
			$this->redirect($this->createUrl('/'));
		}
		
		$content = $this->getModule()->getComponent('contentManager');
		$article = $content->getArticleProvider(array(
				'criteria' => array(
						'condition' => 'id=:id',
						'params' => array(':id'=>$id)
				),
		),0)->getData();
				
		if ( empty($article) ){
			$this->redirect($this->createUrl('/'));
		}
		
		$this->render('view',array('article'=>$article[0]));
	}
}