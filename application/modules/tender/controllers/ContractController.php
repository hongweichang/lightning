<?php
/**
 * @name ContractController.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2014-1-20 
 * Encoding UTF-8
 */
class ContractController extends Controller{
	public function actionIndex(){
		$metano = $this->getQuery('metano');
		
		if ( $metano === null ){
			$this->redirect($this->createUrl('/site'));
		}
		
		$criteria = new CDbCriteria();
		$metano = Utils::appendDecrypt($metano);
		
		//meta中的user为甲方
		$criteria->with = array(
				'bid' => array(
						'with' => array(
								'user' => array(
										'alias' => 'yi'
								)
						)
				),
				'user' => array(
						'alias' => 'jia'
				)
		);
		$meta = BidMeta::model()->findByPk($metano,$criteria);
		
		if ( $meta === null ){
			$this->redirect($this->createUrl('/site'));
		}
		
		$bid = $meta->bid;
		$content = file_get_contents(Yii::getPathOfAlias('application.data.contract').'.html');
		
		$content = str_replace('{{number}}',date('Ymd',$meta->buy_time).$meta->id, $content);//编号
		$content = str_replace('{{nickname_jia}}',$meta->user->nickname, $content);//甲方昵称
		$content = str_replace('{{money}}',$meta->sum, $content);//借款数
		$content = str_replace('{{deadline}}',$bid->deadline, $content);//借款期限，还款分期月数
		$content = str_replace('{{refund_jia}}',$meta->refund, $content);//甲方每月应收本息
		$content = str_replace('{{username_yi}}',$bid->user->realname, $content);//乙方真实姓名
		$content = str_replace('{{nickname_yi}}',$bid->user->nickname, $content);//乙方昵称
		$content = str_replace('{{identitycode}}',substr($bid->user->identity_id,0,5).'*************', $content);//乙方身份证号
		$content = str_replace('{{refund}}',$bid->refund, $content);//乙方月偿还本息数额
		$content = str_replace('{{description}}',$bid->description, $content);//标段描述
		
		$this->layout = false;
		$this->render('index',array('content'=>$content));
	}
}