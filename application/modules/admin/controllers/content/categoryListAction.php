<?php
/**
 * @name categoryListAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-12 
 * Encoding UTF-8
 */
class categoryListAction extends CmsAction{
	public function run(){
		$controller = $this->getController();
		$content = $controller->getContentManager();
		$controller->addToSubtab('添加分类','content/categoryAdd');
		$controller->tabTitle = '分类列表';
		$data = $content->getCategoryProvider(array(
				'pagination' => array(
						'pageSize' => 15
				),
		));
		$this->render('categoryList',array('dataProvider'=>$data));
	}
}