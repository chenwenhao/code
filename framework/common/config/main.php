<?php
// 定义数据库配置
if(defined('YII_DEBUG') && YII_DEBUG)
{
	define('DB_HOST', '127.0.0.1');
	define('DB_USER', "root");
	define('DB_PASSWORD', "root");
	define('SCHEMACACHINGDURATION', 0);# 数据库缓存时间
	define('ENABLEPROFILING', false);# 数据库缓存是否开启

	# 开发环境使用文件缓存
	$cache = array(
		'class' => 'CFileCache', //文件缓存
		'cachePath' => ROOT . '/runtime/cache',// 缓存目录
		'directoryLevel' => '1', // 缓存文件的目录深度
	);
	$cache_time = 0;
}
else
{
	define('DB_HOST', '127.0.0.1');
	define('DB_USER', 'root');
	define('DB_PASSWORD', '421023');
	
	if(defined("IS_COMMAND") && IS_COMMAND == TRUE)
	{
		# 脚本程序使用文件缓存，文件缓存可以避免fork子程序使用memcache的一系列问题
		# 关闭数据库缓存
		define('SCHEMACACHINGDURATION', 0);# 数据库缓存时间
		define('ENABLEPROFILING', FALSE);# 数据库缓存是否开启
		$cache = array(
			'class' => 'CFileCache', //文件缓存
			'cachePath' =>  ROOT.'/runtime/cache',// 缓存目录
			'directoryLevel' => '1', // 缓存文件的目录深度
		);
		$cache_time = 0;
	}
	else
	{
		# web服务使用memcache，并开启数据库缓存
		define('SCHEMACACHINGDURATION', 86400);# 数据库缓存时间
		define('ENABLEPROFILING', TRUE);# 数据库缓存是否开启
		$cache = array (
			'class' => 'CFileCache', //文件缓存
			'cachePath' => ROOT . '/runtime/cache',// 缓存目录
			'directoryLevel' => '1', // 缓存文件的目录深度
	   	);
		$cache_time = 3600;
	}
}

$default_conf = array(
	'basePath' => APP_ROOT . '/protected',
	'runtimePath' => ROOT . '/runtime',
	'import' => array(
		'application.modules.*',
		'system.common.extentions.*',
		'system.common.models.*',
	),
	'components' => array(
		'db' => array(
			'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=' . DB_HOST . ';dbname=tuishudan',
			'emulatePrepare' => TRUE,
			'username' => DB_USER,
			'password' => DB_PASSWORD,
			'charset' => 'utf8',
			'tablePrefix' => '',
			'schemaCachingDuration'  => SCHEMACACHINGDURATION, // 数据缓存时间
			'enableProfiling'  => ENABLEPROFILING, // 是否开启数据缓存
		),
		'urlManager' => array(
			'urlFormat' => 'path',
			'showScriptName' => FALSE,
			'rules' => include APP_ROOT . '/protected/config/url.php',
		),
		'request' => array(
			'enableCookieValidation' => TRUE, // 防止Cookie攻击,要用CHttpCookie
		),
		'session' => array(
			'timeout' => 604800,
			'cookieMode' => 'allow',
			'cookieParams' => array('lifetime' => 604800),
			'class' => 'CCacheHttpSession',
			'cacheID' => 'cache',
		),
		'user' => array(
			'allowAutoLogin' => TRUE, // enable cookie-based authentication
			#'identityCookie' => array('domain' => '.rrtxt.com'),
 			'stateKeyPrefix' => 'webdev',
		),
		'cache' => $cache,
		'assetManager' => array(
			'BasePath' => APP_ROOT.'/public/assets',
			'baseUrl' => '/assets',
		),
	),
		
	// 加载全局变量
	// 调用方法 Yii::app()->params['paramName']
	'params' => array(
		'cache_timeout' => $cache_time, // 页面片断缓存时间
		'cover_img_url' => 'http://tuishudan.com/cover_imgs/', // 封面图访问地址
		'cover_img_path' => ROOT . '/tuishudan.com/public/cover_imgs/', // 封面图存储路径
		'book_status' => array(
			0 => '连载',
			1 => '完结',
		),
	),
);
if(file_exists(APP_ROOT . '/protected/config/config.php'))
{
    $custom_config = include APP_ROOT . '/protected/config/config.php';
    return CMap::mergeArray($default_conf, $custom_config);
}
else 
{
    return $default_conf;
}
