<?php
/**
*框架初始化文件
**/
//检查PHP版本
if(version_compare(PHP_VERSION,'5.3.0','<')){
	die('require PHP > 5.3.0 !');
}
//定义系统变量
$GLOBALS['_startTime'] = microtime(true);
$GLOBALS['_rootPath'] = dirname(__DIR__);
$GLOBALS['_appPath'] = realpath($GLOBALS['_appPath']);
$GLOBALS['_appName'] = basename($GLOBALS['_appPath']);
if(!isset($GLOBALS['_isDebug'])){
	$GLOBALS['_isDebug'] = false;
}
//设置报错级别
$GLOBALS['_isDebug'] ? error_reporting(E_ALL) : error_reporting(0);

$_coreFiles = array(
		'Library/Core/LeguanBase',
		'Library/Core/Leguan',
		'Library/Core/Controller',
		'Common/Function'
	);
foreach ($_coreFiles as $fileName) {
	require $fileName.'.php';
}

new App();