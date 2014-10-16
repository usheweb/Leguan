<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\Routing;

use \Leguan\Bootstrap\Leguan;


/**
 * 路由控制类
 */
class Routing
{
	private $_routing = array();

	public function __construct()
	{
		$this->_init();
	}

	/**
	 * 初始化路由配置
	 */
	private function _init()
	{
		$this->_routing = require 'etc.php';
	} 

	public function run()
	{
		$config = Leguan::get('config');
		$urlType = $config->urlType;
		$url = Leguan::get('url');
		$urlType = $url->getUrlType($urlType);
		
		if($urlType === null){
			throw new \Exception('配置中的urlType不在Url::urlType中', 1);
		}

		//重写路由
		if($urlType != 'normal'){
			$this->$urlType();
		}
		//解析url
		$url->$urlType();

		$path = Leguan::get('path');
		//加载模块配置
		$moduleConfig = array($path->appPath, $url->m, 'Config', 'etc.php');
		$moduleConfig = implode($path->ds, $moduleConfig);
		if(file_exists($moduleConfig)){
			$config->load(require $moduleConfig);
		}

		//开启session
		if($config->sessionStart){
			$session = new \Leguan\Session\Session();
			Leguan::set('session',$session);
			$session->start();
		}

		//执行应用级别初始化代码
		$initFile = array($path->app, 'Main.php');
		$initFile = implode($path->ds, $initFile);
		if (file_exists($initFile)) {
			require $initFile;
			$init = new \App\Main();
			if ($init->run() === false) {
				exit;
			}
		}

		//执行模块级别初始化代码
		$initFile = array($path->app, $url->m, 'Main.php');
		$initFile = implode($path->ds, $initFile);
		if (file_exists($initFile)) {
			require $initFile;
			$init = new \App\Moudle\Main();
			if ($init->run() === false) {
				exit;
			}
		}
		//加载控制器
		$controllerName = "\\{$url->m}\\Controller\\{$url->c}Controller";

		$controller = new $controllerName();
		$actionName = "{$url->a}Action";

		$defaultAction = 'defaultAction';
		if (is_callable(array($controller, $actionName))) {
			$controller->$actionName();
		} elseif (is_callable(array($controller, $defaultAction))) {
			$controller->$defaultAction();
		} else {
			$this->defaultAction($controllerName, $actionName);
		}
		
	}

	/**
	 * 未知路由处理函数
	 */
	public function defaultAction($controllerName, $actionName){
		exit("类{$controllerName} {$actionName}方法不存在或不是public");
	}

	/**
	 * 重写路由 - pathInfo
	 */
	public function pathInfo()
	{
		if(!isset($_SERVER['PATH_INFO'])){
			$_SERVER['PATH_INFO'] = '';
		}

		$_SERVER['PATH_INFO'] = $this->_getUrl($_SERVER['PATH_INFO']);
	}

	/**
	 * 重写路由 - rewrite
	 */
	public function rewrite()
	{
		$this->clean();
	}

	/**
	 * 重写路由 - clean
	 */
	public function clean()
	{
		$cleanKey = Leguan::get('url')->getCleanKey();
		
		if(isset($_GET[$cleanKey])){
			$_GET[$cleanKey] = $this->_getUrl($_GET[$cleanKey]);
		}
	}

	/**
	 * 获取重写后的url
	 *
	 * @param $url string
	 * @return string
	 */
	private function _getUrl($url = '')
	{
		if(empty($url)){
			return '';
		}

		foreach ($this->_routing as $value) {
			$from = preg_replace("/(\\$\d)/", '([a-zA-Z_0-9\/])', $value['from']);
			if(preg_match("|{$from}|i", $url)){
				return preg_replace("|{$from}|i", "{$value['to']}", $url);
			}
		}

		return $url;
	}

}