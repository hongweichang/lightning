<?php
set_time_limit(0);

$dir = dirname(__FILE__);
require $dir.'/../../XCms/cms.php';
require $dir.'/../../XCms/core/components/environment/ConsoleEnv.php';
require $dir.'/config/console.php';

$config = new console();
$environment = new ConsoleEnv($config,'CConsoleApplication');
$environment->basePath = $dir.DS;
$environment->run();
