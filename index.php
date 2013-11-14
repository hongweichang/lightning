<?php
/**
 * @name index.php
 * @author lancelot <lancelot1215@gmail.com>
 * Date 2013-11-14
 * Encoding UTF-8
 */
$dir = dirname(__FILE__);
require $dir.'/../XCms/cms.php';
require $dir.'/application/config/mainConf.php';
$config = new mainConf();
$environment = new Environment($config);
$environment->basePath = $dir.DS.'application'.DS;
$environment->run();
?>