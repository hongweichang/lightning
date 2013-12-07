<?php
/**
 * @name Application.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-1 
 * Encoding UTF-8
 * 
 * 1.提供静态文件URL管理方案
 * 
 * 分区是为了防止某一文件夹下过多文件，尤其是有很多小文件，导致硬盘查找时间增加
 * 目前提供一层分区
 * 分区之后目录结构为  存放目录/分区号/文件
 * 
 * 分区号由分区方案确定，分区方案是一个回调函数
 * 默认是使用{@link self::PARTITION_METHOD_ID}作为分区函数，使用某一个唯一的ID来计算，一般是数据库中主键
 * {@link self::PARTITION_METHOD_TIME}提供的则是通过一个时间来计算分区号，默认的，时间会使用date($format)转换成一个numeric类型的字符串
 * 再进行计算，默认格式是Ymd，如20110508
 * 
 * 可以自己定义分区方案
 * 配置获取相关url时的回调函数
 * 如 array(
 * 		'siteBanner' => array('Foo','partition') //使用Foo::partition()进行分区
 * )，
 * 若回调函数需要别的参数，在获取URL时应以数组形式给出，
 * 如 $this->getSiteBanner($params);
 */
class Application extends CmsApplication{
	/**
	 * 默认文件分区方案
	 * 通过ID来对文件分区
	 * @var string
	 */
	const PARTITION_METHOD_ID = 'partitionById';
	/**
	 * 通过时间来对文件分区
	 * 默认为以 Ymd 格式命名文件夹
	 * @var string
	 */
	const PARTITION_METHOD_TIME = 'partitionByTime';
	/**
	 * 分区个数
	 * @var int
	 */
	public $partitionNum = 10000;
	/**
	 * 以时间分区时，文件夹的命名方式
	 * @var string
	 */
	public $timePartitionFormat = 'Ymd';
	/**
	 * 网站域名
	 * 格式为http[s]://foo.bar.com
	 * @var string
	 */
	public $hostName = 'http://127.0.0.1';
	/**
	 * 网站基地址
	 * 值为 $hostName + UrlManager::getBaseUrl()
	 * 默认和域名一致
	 * 以下其他地址均为相对地址，相对于基地址
	 * 此设计是为了能够在使用磁盘地址的时候复用
	 * @var string
	 */
	private $_siteBaseUrl = 'http://localhost';
	
	private $_nameMap = array(
			'js' => array(
					'path' => 'UED/javascript/'
			),
			'css' => array(
					'path' => 'UED/css/'
			),
			'image' => array(
					'path' => 'UED/images/'
			),
			'upload' => array(
					'path' => 'upload/'
			),
			'avatar' => array(
					'partitionMethod' => self::PARTITION_METHOD_ID,
					'path' => 'upload/avatar/'
			),
			'siteBanner' => array(
					'partitionMethod' => self::PARTITION_METHOD_TIME,
					'path' => 'upload/banners/site/'
			),
			'appBanner' => array(
					'partitionMethod' => self::PARTITION_METHOD_TIME,
					'path' => 'upload/banners/app/'
			),
			'creditFile' => array(
					'partitionMethod' => self::PARTITION_METHOD_ID,
					'path' => 'upload/credit/'
			),
			'bidFile' => array(
					'partitionMethod' => self::PARTITION_METHOD_ID,
					'path' => 'upload/bid/'
			),
	);
	
	public $urlManagerBaseUrl = null;
	
	public function init(){
		parent::init();
		$url = $this->getUrlManager();
		if ( $this->urlManagerBaseUrl !== null ){
			$url->setBaseUrl($this->urlManagerBaseUrl);
		}
		$this->_siteBaseUrl = $this->hostName.$url->getBaseUrl().'/';
	}
	
	/**
	 * 设置某个项目的路径
	 * @param string $name
	 * @param string $value
	 */
	public function setPath($name,$value){
		if ( isset($this->_nameMap[$name]) ){
			$this->_nameMap[$name]['path'] = $value;
		}
	}
	
	/**
	 * 设置某个项目的配置，包括分区方案等
	 * @param array $config
	 */
	public function setNameMap($config){
		foreach ( $config as $key => $c ){
			if ( isset($this->_nameMap[$key]) && $c === null ){
				unset($this->_nameMap[$key]);
			}else {
				$this->_nameMap[$key] = $c;
			}
		}
	}
	
	/**
	 * 获取网站基地址
	 * @return string
	 */
	public function getSiteBaseUrl(){
		return $this->_siteBaseUrl;
	}
	
	/**
	 * 获取某以项目路径
	 * @param string $name
	 * @return string
	 */
	public function getPath($name){
		if ( isset($this->_nameMap[$name]) && isset($this->_nameMap[$name]['path']) ){
			return $this->_nameMap[$name]['path'];
		}else {
			return null;
		}
	}
	
	/**
	 * 根据分区输入参数和分区方案，返回项目分区后的地址
	 * @param string $name
	 * @param mixed $partIn
	 * @return string|NULL
	 */
	public function getPartedUrl($name,$partIn=null){
		if ( isset($this->_nameMap[$name]) && isset($this->_nameMap[$name]['path']) ){
			$part = $this->partition($partIn,$name);
			return $this->_siteBaseUrl.$this->_nameMap[$name]['path'].$part;
		}else {
			return null;
		}
	}
	
	/**
	 * 根据项目分区配置对项目选用分区方案
	 * @param mixed $partIn
	 * @param string $from
	 * @return NULL|string
	 */
	public function partition($partIn,$from){
		if ( $partIn === null ){
			return null;
		}
		if ( !isset($this->_nameMap[$from]) || !isset($this->_nameMap[$from]['partitionMethod']) ){
			return null;
		}
		
		$func = $this->_nameMap[$from]['partitionMethod'];
		if ( is_string($func) ){//使用自带分区方案
			$part = call_user_func_array(array($this,$func),array('partIn'=>$partIn));
		}elseif ( is_array($partIn) ) {//使用用户自定义分区方案
			$part = call_user_func_array($func,$partIn);
		}else {
			return null;
		}
		
		if ( empty($part) ){
			return null;
		}
		return $part.'/';
	}
	
	/**
	 * 根据ID分区
	 * @param int $partIn
	 * @return number
	 */
	public function partitionById($partIn){
		return $partIn % $this->partitionNum;
	}
	
	/**
	 * 根据时间分区
	 * @param number $partIn
	 * @return NULL|number
	 */
	public function partitionByTime($partIn=null){
		$time = empty($partIn) ? time() : $partIn;
		if ( is_numeric($time) === false ){
			return null;
		}
		
		return $time % $this->partitionNum;
	}
}