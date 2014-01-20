<?php
/**
 * @name editContractAction.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2014-1-19 
 * Encoding UTF-8
 */
class editContractAction extends CmsAction{
	public function run(){
		$post = $this->getPost('EditContractForm');
		$filename = Yii::getPathOfAlias('application.data.contract').'.html';
		if ( $post === null ){
			$model = new EditContractForm();
			$model->content = file_get_contents($filename);
			$this->getController()->addNotifications('请勿删除  {{...}}  之类的内容');
			$this->render('editContract',array('model'=> $model));
			$this->app->end();
		}else {
			file_put_contents($filename,$post['content']);
			$this->getController()->showMessage('修改成功','content/editContract');
		}
	}
}