<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// Debug solo en localhost
if ($_SERVER['SERVER_ADDR'] == "::1" && strpos($_SERVER['REQUEST_URI'], 'gii') === FALSE)
{
	echo "<div style='position:fixed;top:0;left:0;padding:0 2px;color:white;background:red;z-index:99999;'>MODE: localhost (".$_SERVER['SERVER_ADDR'].")</div>";
	// remove the following lines when in production mode
	defined('YII_DEBUG') or define('YII_DEBUG',true);
	// specify how many levels of call stack should be shown in each log message
	defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);	
}

require_once($yii);
Yii::createWebApplication($config)->run();
