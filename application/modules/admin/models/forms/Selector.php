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
	
	public static function load($modelName,$data,$criteria){
		$selector = new $modelName;
		$selector->attributes = $data;
		if ( $selector->validate() ){
			$selector->setConfig($selector->attributes);
			$selector->applyCondition($criteria);
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
	public function applyCondition($criteria){
		foreach ( $this->_config as $column => $value ){
			if ( isset($value) ){
				if ( is_array($value) ){
					$criteria->addBetweenCondition($column,$value[0],$value[1],'OR');
				}else {
					$criteria->addSearchCondition($column,$value,true,'OR');
				}
			}
		}
	}
}