<?php
/**
 * @name ContentController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-12 
 * Encoding UTF-8
 */
class ContentController extends Admin{
	public function getActionClass(){
		return array(
				'categoryList',//分类列表
				'categoryAdd',//添加分类
				'categoryEdit',//编辑分类
				'categoryDelete',//删除分类
				'articleList',//文章列表
				'articleEdit',//编辑文章
				'articleAdd',//添加文章
				'articleDelete',//删除文章
				'adBanner',//广告banner方案
				'adBannerAdd',//添加广告banner方案
				'adBannerEnable',//启用广告banner方案
				'adBannerDetail',//广告banner详情查看
				'officialHelp',//官方宝典列表
				'officialHelpAdd',//添加官方宝典
				'officialHelpEdit',//编辑官方宝典
				'officialHelpDelete',//删除官方宝典
				'faq',//提问列表
				'faqReply',//回复提问
				'faqDelete',//删除提问
				'app',//app动态列表
		);
	}
	
	public function getContentManager(){
		return $this->app->getModule('content')->getComponent('contentManager');
	}
	
	public function artList($type){
		$content = $this->getContentManager();
		
		$config = array(
				'criteria' => array(
						'with' => array(
								'category'
						),
				),
				'pagination' => array(
						'pageSize' => 20
				),
		);
		$dataProvider = $content->getArticleProvider($config,$type);
		
		$this->render('articleList',array('dataProvider'=>$dataProvider,'type'=>$type));
	}
	
	public function artAdd($type){
		$data = $this->getPost('ArticleForm');
		$form = $this->getContentManager()->saveArticle($data,$type);
		if ( $form === true ){
			$action = $type == 0 ? 'articleList' : 'officialHelp';
			$this->showMessage('添加成功','content/'.$action);
		}
		
		$postAction = $type == 0 ? 'articleAdd' : 'officialHelpAdd';
		$this->render('articleForm',array('model'=>$form,'action'=>$this->createUrl('content/'.$postAction) ) );
	}
	
	public function artEdit($type){
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('administrator/view')));
		$id = $this->getQuery('id',null);
		$data = $this->getPost('ArticleForm');
		$result = $this->getContentManager()->updateArticle($id,$data);
		
		if ( $result === true ){
			$this->showMessage('编辑成功',$redirect,false);
		}elseif ( $result->modelExists === false ){
			$this->showMessage('编辑失败，文章不存在',$redirect,false);
		}
		
		$postUrl = $type == 0 ? 'articleEdit' : 'officialHelpEdit';
		$action = $this->createUrl('content/'.$postUrl,array('id'=>$id,'redirect'=>urlencode($redirect)) );
		$this->render('articleForm',array('model'=>$result,'action'=>$action ));
	}
	
	public function artDelete(){
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('administrator/view')));
		$id = $this->getQuery('id',null);
		$content = $this->getContentManager();
		
		$result = $content->deleteArticle($id);
		if ( $result ){
			$this->showMessage('删除成功',$redirect,false);
		}else {
			$this->showMessage('删除失败，管理员不存在',$redirect,false);
		}
	}
}