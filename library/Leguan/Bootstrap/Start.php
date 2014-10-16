<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\Bootstrap;

use \Leguan\Config\Config;
use \Leguan\Url\Url;
use \Leguan\Routing\Routing;

/**
 * 框架引导类
 */
class Start
{
	/**
	 * 框架初始化
	 */
	private static function _init()
	{
		//记录开始时间
		define('APP_START_TIME', microtime(true));
		//记录开始内存
		define('APP_START_MEMORY', memory_get_usage());
		//leguan版本信息
		define('LEGUAN_VERSION', '0.1.0');

		//检查PHP版本
		if (version_compare(PHP_VERSION, '5.3.0', '<')) {
			die('require PHP > 5.3.0 !');
		}

		//加载引导文件
		$coreFiles = array('Path','Leguan');
		foreach ($coreFiles as $value) {
			require "{$value}.php";
		}
		$path = new Path();
		Leguan::set('path',$path);

		//设置include的路径
		$new_include_path = array('.', $path->lib, $path->app);
		$new_include_path = implode($path->ps, $new_include_path);
		set_include_path($new_include_path);

		//注册 类加载器
		spl_autoload_register('self::autoLoader');

		$config = Leguan::get('config');
		defined('APP_NAME') && $config->app = APP_NAME;
		defined('IS_DEBUG') && $config->isDebug = IS_DEBUG;
		
		//加载应用公共配置
		$appConfig = $path->appConfig . $path->ds . 'etc.php';
		if(file_exists($appConfig)){
			$config->load(require $appConfig);
		}

		$config->isDebug ? error_reporting(E_ALL) : error_reporting(0);
		date_default_timezone_set($config->timezone);
		
		$response = Leguan::get('response');
		$response->setCharset($config->charset);
		$response->gzip();
		Leguan::get('url')->setCleanKey($config->urlCleanKey);

		//模拟gpc
		if ($config->gpc && !get_magic_quotes_gpc()) {
			$security = Leguan::get('security');

		    if (!empty($_GET)) {
		        $_GET  = $security->addslashesDeep($_GET);
		    }
		    if (!empty($_POST)) {
		        $_POST = $security->addslashesDeep($_POST);
		    }
		    //转义pathinfo
		    if (!empty($_SERVER['PATH_INFO'])) {
		    	$_SERVER['PATH_INFO'] = $security->addslashesDeep($_SERVER['PATH_INFO']);
		    }

		    $_COOKIE   = $security->addslashesDeep($_COOKIE);
		    $_REQUEST  = $security->addslashesDeep($_REQUEST);
		}
	}

	/**
	 * 框架入口
	 */
	public static function run()
	{
		self::_init();
		Leguan::get('routing')->run();
	}

	/**
	 * 类自动加载器
	 */
	public static function autoLoader($className)
	{
		$path = leguan::get('path');
		$className = ltrim($className, '\\');
		$className = str_replace('\\', $path->ds, $className);
		
		require "{$className}.php";
	} 
}