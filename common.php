<?php
header("Content-type: text/html; charset=utf-8");
header('P3P: CP=CAO PSA OUR');

// 时区设置
date_default_timezone_set('Asia/Shanghai');

// 调试模式，在生产环境中请删除此行
if($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == 'localhost')
	defined('YII_DEBUG') or define('YII_DEBUG', TRUE);

if(defined('YII_DEBUG') && YII_DEBUG)
{
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);
}

// 命令行配置
if(defined("IS_COMMAND"))
{
	$config = ROOT . '/framework/common/config/main.php';
	require_once(ROOT . '/framework/yiic.php');
}
// WEB配置
else
{
	include_once ROOT . '/framework/yiilite.php';
	Yii::createWebApplication(ROOT . '/framework/common/config/main.php')->run();
}