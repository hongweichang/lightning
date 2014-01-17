<?php
/**
 * @name Selector.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-10 
 * Encoding UTF-8
 */
class Selector extends CFormModel{
	private $_config = array();
	private $_elements = array();
	
	public static function load($modelName,$data,$criteria,$operator='OR'){
		$selector = new $modelName;
		$selector->attributes = $data;
		if ( $selector->validate() ){
			$selector->setConfig($selector->attributes);
			$selector->applyCondition($criteria,$operator);
		}
		return $selector;
	}
	
	public function setConfig($config){
		foreach ( $config as $column => $value ){
			$this->_config[$column] = $value;
		}
	}
	
	/**
	 * 
	 * @param CDbCriteria $criteria
	 */
	public function applyCondition($criteria,$operator='OR'){
		foreach ( $this->_config as $column => $value ){
			if ( isset($value) ){
				if ( is_array($value) ){
					if ( empty($value[1]) ){
						$criteria->compare($column, '>='.$value[0]);
					}elseif( empty($value[0]) ){
						$criteria->compare($column, '<='.$value[1]);
					}else {
						$criteria->addBetweenCondition($column,$value[0],$value[1],$operator);
					}
				}else {
					$criteria->addSearchCondition($column,$value,true,$operator);
				}
			}
		}
	}
}