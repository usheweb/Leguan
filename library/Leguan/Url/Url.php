<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\Url;

use \Leguan\Bootstrap\Leguan;

/**
 * url控制类
 */
class Url
{
	//url信息
	private $_url = array();
	//路由类型
	private $_urlType = array('normal','pathInfo','rewrite','clean');
	//pathinfo 兼容模式key
	private $_cleanKey = 'l';

	public function __get($name)
	{
		return $this->get($name);
	}


	public function __set($name, $value)
	{
		$this->set($name, $value);
	}

	/**
	 * 修改clean key
	 *
	 * @param $key string
	 * @return void
	 */
	public function setCleanKey($key)
	{
		$this->_cleanKey = $key;
	}

	/**
	 * 获取url clean key
	 *
	 * @return string 
	 */
	public function getCleanKey()
	{
		return $this->_cleanKey;
	}

	/**
	 * 获取url
	 *
	 * @return array
	 */
	public function getUrlAll()
	{
		return $this->_url;
	}

	/**
	 * 设置url
	 *
	 * @return array
	 */
	public function setUrlAll($arr)
	{
		$this->_url = $arr;
	}

	/**
	 * 获取url类型
	 *
	 * @param $type int
	 * @return mixed
	 */
	public function getUrlType($type)
	{
		if(isset($this->_urlType[$type])){
			return $this->_urlType[$type];
		}

		return null;
	}

	/**
	 * 设置路径键值信息
	 *
	 * @param $name string
	 * @param $value string
	 * @return void
	 */
	public function set($name, $value)
	{
		$this->_url[$name] = $value;
	}

	/**
	 * 获取路径中的键值信息
	 * 
	 * @param $name string
	 * @return string
	 */
	public function get($name)
	{
		if(isset($this->_url[$name])){
			return $this->_url[$name];
		}

		return null;
	}

	/**
	 *	url解析 - normal
	 */
	public function normal()
	{
		$config = Leguan::get('config');
	    !isset($_GET['m']) && $_GET['m'] = $config->defaultModule;
	    !isset($_GET['c']) && $_GET['c'] = $config->defaultController;
	    !isset($_GET['a']) && $_GET['a'] = $config->defaultAction;

	    foreach ($_GET as $key => $value) {
	    	$this->_url[$key] = $value;
	    }

	    $this->_ucwords();
	}

	/**
	 *	url解析 - pathinfo
	 */
	public function pathInfo()
	{
		if(!isset($_SERVER['PATH_INFO'])){
			$_SERVER['PATH_INFO'] = '';
		}

		$this->parseUrl($_SERVER['PATH_INFO']);
	}

	/**
	 *	url解析 - rewrite
	 */
	public function rewrite()
	{
		$this->clean();
	}

	/**
	 *	url解析 - clean
	 */
	public function clean()
	{
		if(!isset($_GET[$this->_cleanKey])){
			$_GET[$this->_cleanKey] = '';
		}

		$this->parseUrl($_GET[$this->_cleanKey]);
	}

	/**
	 * url解析
	 *
	 * @param $path string
	 */
	public function parseUrl($path = '')
	{
		$pathArr = $this->_getPathArr($path);

        $this->_url['m'] = $pathArr[0];
        $this->_url['c'] = $pathArr[1];
        $this->_url['a'] = $pathArr[2];
        $this->_ucwords();
		//去除$pathArr前3个成员
		array_splice($pathArr,0,3);

		$pathKeys = array();
		$pathValues = array();
		foreach ($pathArr as $key => $value) {
			if($key % 2 == 0){
				array_push($pathKeys, $value);
			}else{
				array_push($pathValues, $value);
			}
		}
		
		if($pathKeys || $pathValues){
			$pathCombine = array_combine($pathKeys, $pathValues);
			//把url转换成数组保存
			$this->_url = array_merge($this->_url,$pathCombine);
		}
	}

	/**
	 * 获取path补全m a c后的默认值后的array
	 */
	private function _getPathArr($path)
	{
		$config = Leguan::get('config');
		$urlExtension = $config->urlExtension;
		$urlLimiter = $config->urlLimiter;

		$path = trim($path);
		$path = trim($path,'/');
		$path = trim($path,$urlLimiter);
		$path = rtrim($path,$urlExtension);
		if (empty($path)) {
			$pathArr = array();
		} else {
			$pathArr = explode($urlLimiter, $path);
		}

		//给url补全缺省m c a
		empty($pathArr[0]) && array_push($pathArr, $config->defaultModule);
		empty($pathArr[1]) && array_push($pathArr, $config->defaultController);
		empty($pathArr[2]) && array_push($pathArr, $config->defaultAction);

		return $pathArr;
	}

	/**
	 * m c a 大小写处理
	 */
	private function _ucwords()
	{
		$this->_url['m'] = ucwords(strtolower($this->_url['m']));
		$this->_url['c'] = ucwords(strtolower($this->_url['c']));
		$this->_url['a'] = strtolower($this->_url['a']);
	}

	/**
	 * 获取url
	 *
	 * @param $path string
	 * @return string
	 */
	public function getUrl($path, $hasDomain = false)
	{
		$config = Leguan::get('config');
		$urlType = $this->getUrlType($config->urlType);
		$urlType = ucwords($urlType);
		$action = "_get{$urlType}Url";
		$url = '';

		if ($hasDomain) {
			$request = Leguan::get('request');
			$url = $request->getDomain();
		}

		$url = $url . $this->$action($path);

		return $url;
	}

	private function _getNormalUrl($path)
	{
		$pathArr = $this->_getPathArr($path);
		$urlArr['m'] = $pathArr[0];
		$urlArr['c'] = $pathArr[1];
		$urlArr['a'] = $pathArr[2];
		array_splice($pathArr,0,3);

		$pathKeys = array();
		$pathValues = array();
		foreach ($pathArr as $key => $value) {
			if($key % 2 == 0){
				array_push($pathKeys, $value);
			}else{
				array_push($pathValues, $value);
			}
		}
		
		if($pathKeys || $pathValues){
			$pathCombine = array_combine($pathKeys, $pathValues);
			$urlArr = array_merge($urlArr,$pathCombine);
		}

		$url = '?';
		foreach ($urlArr as $key => $value) {
			$url .= "{$key}={$value}&";
		}

		return "/index.php".rtrim($url,'&');
	}

	private function _getPathInfoUrl($path)
	{
		return "/index.php".$this->_getPathUrl($path);
	}

	private function _getRewriteUrl($path)
	{
		return $this->_getPathUrl($path);
	}

	private function _getCleanUrl($path)
	{
		return "/index.php?{$this->_cleanKey}=".$this->_getPathUrl($path);
	}

	private function _getPathUrl($path)
	{
		$pathArr = $this->_getPathArr($path);
		$urlArr = array();
		array_unshift($urlArr, array_pop($pathArr));
		array_unshift($urlArr, array_pop($pathArr));
		array_unshift($urlArr, array_pop($pathArr));
		
		foreach ($pathArr as $key => $value) {
			array_push($urlArr, $key);
			array_push($urlArr, $value);
		}

		$config = Leguan::get('config');

		return "/".implode('/', $urlArr).$config->urlExtension;
	}

}