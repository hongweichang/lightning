<?php
/**
 * file: IpsController.php
 * author: Toruneko<toruneko@outlook.com>
 * date: 2013-11-20
 * desc: 环迅支付p2p交易接口接入页
 */
class IpsController extends PayController{
	protected $platform = 'ips';
	
	public function init(){
		parent::init();
		$this->module->setImport(array(	
			'pay.extensions.ips.*'
		));
	}
	
	public function actionOrder(){
		$order = $this->getPayOrder();
		if($order->getAttribute('user_id') != $this->user->getId())
			throw new CHttpException(404);
		
		$amount = round(($order->getAttribute('sum') + $order->getAttribute('fee')) / 100,2);
		$ips = $this->module->ips;
		$ips['Billno'] = $order->getAttribute('id');
		$ips['Amount'] = number_format($amount,2,".","");
		$ips['Attach'] = '闪电贷:'.$amount.'元(含手续费:'.($order->getAttribute('fee') / 100).'元)';
		$ips['Date'] = date('Ymd');
		unset($ips['Mer_key']);
		
		$submit = new IpsSubmit($this->module->ips);
		$html = $submit->buildRequestForm($ips, 'post', '');
		echo $html;
	}
	
	public function actionReturn(){
		$ipsNotify = new IpsNotify($this->module->ips);
		$result = $ipsNotify->verify();
		
		if($result){
			if($this->getQuery('succ') == 'Y'){
				$this->trade_no = $this->getQuery('ipsbillno');
				$this->subject = urldecode($this->getQuery('attach',''));
				$this->buyer = '银行卡';//urldecode(strtoupper($this->getQuery('msg')));
				$this->buyer_id = $this->getQuery('bankbillno');
				
				if($this->beginPay($this->getQuery('billno'))){
					$record = Recharge::model()->findByPk($this->getQuery('billno'));
					if($record->getAttribute('meta_id') != 0){
						$meta = Yii::app()->getModule('tender')->bidManager->getBidMetaInfo($record->getAttribute('meta_id'));
						$this->render('/compelete',array(
							'metano' => Utils::appendEncrypt($record->getAttribute('meta_id')),
							'bid' => $meta->getRelated('bid')->getAttribute('id'),
						));
					}else{
						$this->render('/success');
					}
				}else{
					$this->render('/failure',array(
						'title' => '充值出错'
					));
				}
			}else{
				$this->render('/failure',array(
					'title' => '充值失败'
				));
			}
		}else{
			$this->render('/failure',array(
				'title' => '签名验证失败'
			));
		}
	}
	
	public function actionNotify(){
		$ipsNotify = new IpsNotify($this->module->ips);
		$result = $ipsNotify->verify();
		
		if($result){
			if($this->getQuery('succ') == 'Y'){
				/**----------------------------------------------------
				 *比较返回的订单号和金额与您数据库中的金额是否相符
				*compare the billno and amount from ips with the data recorded in your datebase
				*----------------------------------------------------
		
				if(不等)
					echo "从IPS返回的数据和本地记录的不符合，失败！"
				exit
				else
					'----------------------------------------------------
				'交易成功，处理您的数据库
				'The transaction is successful. update your database.
				'----------------------------------------------------
				end if
				**/
				$this->trade_no = $this->getQuery('ipsbillno');
				$this->subject = urldecode($this->getQuery('attach',''));
				$this->buyer = '银行卡';//urldecode(strtoupper($this->getQuery('msg')));
				$this->buyer_id = $this->getQuery('bankbillno');
				if($this->beginPay($this->getQuery('billno')) && $this->afterPay($this->getQuery('billno'))){
					echo "ipscheckok";
				}else{
					echo "ipscheckno";
				}
			}else{
				echo "ipscheckno";
			}
		}else{
			echo "ipscheckno";
		}
	}
}