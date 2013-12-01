<?php
/**
 * @name BidManager.php
 * @author wxweven wxweven@163.com
 * Date 2013-11-27 
 * Encoding UTF-8
 */
class BidManager extends CApplicationComponent{	
	/**
	 * 根据标段的id,返回标段的详细信息
	 * Enter description here ...
	 * @param $bidId
	 * @return $bidDetail 标段的详细信息
	 */
	public function getBidDetail($bidId,$condition='',$params=array()) {
		return BidInfo::model()->findByPk( $bidId ,$condition,$params); // 通过标段id来获取标段信息
	}
}