<?php
/**
 * @name Application.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-12-1 
 * Encoding UTF-8
 * 
 * 提供静态文件URL管理方案
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
	
	private $_partitionMethod = array(
			'siteBanner' => self::PARTITION_METHOD_TIME,
			'appBanner' => self::PARTITION_METHOD_TIME,
			'avatar' => self::PARTITION_METHOD_ID,
			'creditFile' => self::PARTITION_METHOD_ID,
			'bidFile' => self::PARTITION_METHOD_ID
	);
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
	private $_siteBaseUrl = 'http://127.0.0.1';
	/**
	 * js地址
	 * @var string
	 */
	private $_jsUrl = 'UED/javascript/';
	/**
	 * css地址
	 * @var string
	 */
	private $_cssUrl = 'UED/css/';
	/**
	 * 网站静态图片地址
	 * @var string
	 */
	private $_imageUrl = 'UED/images/';
	/**
	 * 上传到网站上的图片的地址
	 * @var string
	 */
	private $_uploadUrl = 'upload/';
	/**
	 * 网站banner存放地址
	 * @var string
	 */
	private $_siteBannerUrl = 'upload/banners/site/';
	/**
	 * app端banner存放地址
	 * @var string
	 */
	private $_appBannerUrl = 'upload/banners/app/';
	/**
	 * 用户头像地址
	 * @var string
	 */
	private $_avatarUrl = 'upload/avatar/';
	/**
	 * 信用资料文件地址
	 * @var string
	 */
	private $_creditFileUrl = 'upload/credit/';
	/**
	 * 标段资料文件地址
	 * @var string
	 */
	private $_bidFileUrl = 'upload/bid/';
	
	public function init(){
		parent::init();
		$this->_siteBaseUrl = $this->hostName.$this->getUrlManager()->getBaseUrl().'/';
	}
	
	public function setJsUrl($url){
		$this->_jsUrl = $url;
	}
	
	public function setCssUrl($url){
		$this->_cssUrl = $url;
	}
	
	public function setImageUrl($url){
		$this->_imageUrl = $url;
	}
	
	public function setUploadUrl($url){
		$this->_uploadUrl = $url;
	}
	
	public function setSiteBannerUrl($url){
		$this->_siteBannerUrl = $url;
	}
	
	public function setAppBannerUrl($url){
		$this->_appBannerUrl = $url;
	}
	
	public function setAvatarUrl($url){
		$this->_avatarUrl = $url;
	}
	
	public function setCreditFileUrl($url){
		$this->_creditFileUrl = $url;
	}
	
	public function setBidFileUrl($url){
		$this->_bidFileUrl = $url;
	}
	
	public function setPartitionMethod($config){
		foreach ( $config as $key => $c ){
			if ( isset($this->_partitionMethod[$key]) && $c === null ){
				unset($this->_partitionMethod[$key]);
			}else {
				$this->_partitionMethod[$key] = $c;
			}
		}
	}
	
	public function getSiteBaseUrl(){
		return $this->_siteBaseUrl;
	}
	
	public function getJsUrl(){
		return $this->_siteBaseUrl.$this->_jsUrl;
	}
	
	public function getCssUrl(){
		return $this->_siteBaseUrl.$this->_cssUrl;
	}
	
	public function getImageUrl(){
		return $this->_siteBaseUrl.$this->_imageUrl;
	}
	
	public function getUploadUrl(){
		return $this->_siteBaseUrl.$this->_uploadUrl;
	}
	
	public function getSiteBannerUrl($partIn=null){
		$part = $this->partition($partIn,'siteBanner');
		return $this->_siteBaseUrl.$part.$this->_siteBannerUrl;
	}
	
	public function getAppBannerUrl($partIn=null){
		$part = $this->partition($partIn,'appBanner');
		return $this->_siteBaseUrl.$part.$this->_appBannerUrl;
	}
	
	public function getAvatarUrl($partIn=null){
		$part = $this->partition($partIn,'avatar');
		return $this->_siteBaseUrl.$part.$this->_avatarUrl;
	}
	
	public function getCreditFileUrl($partIn=null){
		$part = $this->partition($partIn,'creditFile');
		return $this->_siteBaseUrl.$part.$this->_creditFileUrl;
	}
	
	public function getBidFileUrl($partIn=null){
		$part = $this->partition($partIn,'bidFile');
		return $this->_siteBaseUrl.$part.$this->_bidFileUrl;
	}
	
	public function partition($partIn,$from){
		if ( $partIn === null ){
			return null;
		}
		if ( isset($this->_partitionMethod[$from]) === false ){
			return null;
		}
		
		$func = $this->_partitionMethod[$from];
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
	
	public function partitionById($partIn){
		return $partIn % $this->partitionNum;
	}
	
	public function partitionByTime($partIn=null){
		$time = empty($partIn) ? time() : $partIn;
		if ( is_numeric($time) === false ){
			return null;
		}
		
		return $time % $this->partitionNum;
	}
}