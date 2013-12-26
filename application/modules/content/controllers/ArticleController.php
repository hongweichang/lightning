<?php
/**
 * @name ArticleController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-20 
 * Encoding UTF-8
 */
class ArticleController extends ContentController{
	public function noneLoginRequired(){
		return 'view,index';
	}
	
	public function actionIndex(){
		$list = $this->content->getArticleProviderViaType(array(),0);
		$data = $list->getData();
		$pager = $list->getPagination();
		
		$this->render('list',array(
				'articles' => $data,
				'pager' => $pager
		));
	}
	
	public function actionView(){
		$id = $this->getQuery('id');
		if ( $id === null ){
			$this->redirect($this->createUrl('/site'));
		}
		
		$article = $this->content->getArticleProvider(array(
				'criteria' => array(
						'condition' => 'id=:id',
						'params' => array(':id'=>$id)
				),
		))->getData();
				
		if ( empty($article) ){
			$this->redirect($this->createUrl('/site'));
		}
		
		$this->render('view',array('article'=>$article[0]));
	}
}