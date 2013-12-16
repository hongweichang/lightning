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
				'userMessage',//用户留言列表
				'userMessageReply',//用户留言回复
				'userMessageDelete',//用户留言删除
				'app',//app动态列表
				'appAdd',//添加app动态
				'appDetail',//app动态详情
		);
	}
	
	/**
	 * @return ContentManager
	 */
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
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('index/welcome')));
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
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('index/welcome')));
		$id = $this->getQuery('id',null);
		$content = $this->getContentManager();
		
		$result = $content->deleteArticle($id);
		if ( $result ){
			$this->showMessage('删除成功',$redirect,false);
		}else {
			$this->showMessage('删除失败，管理员不存在',$redirect,false);
		}
	}
	
	public function bannerList($type){
		$content = $this->getContentManager();
		
		$dataProvider = $content->getBannerProvider(array(
				'criteria' => array(
						'order' => 'is_using DESC,add_time DESC'
				),
				'pagination' => array(
						'pageSize' => 15
				),
		),$type);
		$data = $dataProvider->getData();
		foreach ( $data as $i => $scheme ){
			$data[$i]->file_names = json_decode($scheme->file_names,true);
		}
		$dataProvider->setData($data);
		
		return $dataProvider;
	}
	
	public function bannerAdd($type){
		$data = $this->getPost('BannerSchemeForm');
		$form = $this->getContentManager()->saveBanner($data,$type);
		
		return $form;
	}
	
	public function bannerDetail($type,$viewName){
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('index/welcome')));
		$id = $this->getQuery('id',null);
		if ( $id === null ){
			$this->showMessage('目标不存在',$redirect,false);
		}
		
		$provider = $this->getContentManager()->getBannerProvider(array(
				'criteria' => array(
						'condition' => 'id=:id',
						'params' => array(
								':id' => $id
						)
				)
		),$type,false,false);
		$data = $provider->getData();
		
		if ( empty($data) ){
			$this->showMessage('目标不存在',$redirect,false);
		}
		
		$data = $data[0];
		$files = json_decode($data->file_names,true);
		$addTime = $data->add_time;
		$bannerName = $type === 0 ? 'siteBanner' : 'appBanner';
		foreach ( $files as $i => $file ){
			$files[$i]['filename'] = $this->app->getPartedUrl($bannerName,$addTime).$file['filename'];
		}
		
		$this->tabTitle = '方案配置详情';
		$this->render($viewName,array('model'=>$data,'files'=>&$files,'redirect'=>$redirect));
	}
	
	public function faqList($type){
		$content = $this->getContentManager();
		
		$dataProvider = $content->getFaqProvider(array(
				'criteria' => array(
						'order' => 'add_time DESC'
				),
				'pagination' => array(
						'pageSize' => 15
				),
		),$type);
		
		$this->render('faq',array('dataProvider'=>$dataProvider,'type'=>$type));
	}
	
	public function faqReplyView($type){
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('index/welcome')));
		$id = $this->getQuery('id',null);
		$content = $this->getContentManager();
		
		$userDataProvider = $content->getFaqProvider(array(
				'criteria' => array(
						'alias' => 'faq',
						'condition' => 'faq.id=:id',
						'params' => array(
								':id' => $id
						),
				),
		),$type,true,false);
		$userData = $userDataProvider->getData();
		if ( empty($userData) ){
			$this->showMessage('目标不存在',$redirect);
		}
		
		$replyData = $this->getPost('ArticleFaqReplyForm');
		$result = $content->replyFaq($id,$replyData,$type);
		if ( $result === true ){
			$this->showMessage('回复成功',$redirect,false);
		}
		
		$dataProvider = $content->getFaqProvider(array(
				'criteria' => array(
						'condition' => 'fid=:fid',
						'params' => array(
								':fid' => $id
						),
				),
		),$type+1,true,false);
		
		$action = $this->createUrl('',array('id'=>$id,'redirect'=>urlencode($redirect)));
		$this->render('faqReplyView',array('model'=>$result,'dataProvider' => $dataProvider,'userDataProvider'=>$userDataProvider,'action'=>$action));
	}
	
	public function faqDelete(){
		$redirect = urldecode($this->getQuery('redirect',$this->createUrl('index/welcome')));
		$id = $this->getQuery('id',null);
		$content = $this->getContentManager();
		
		$result = $content->deleteFaq($id);
		if ( $result ){
			$this->showMessage('删除成功',$redirect,false);
		}else {
			$this->showMessage('删除失败，目标不存在',$redirect,false);
		}
	}
}