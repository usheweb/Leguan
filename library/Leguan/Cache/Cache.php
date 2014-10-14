<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

 namespace Leguan\Cache;

use Leguan\Bootstrap\Leguan;

/**
 * 缓存控制类
 */
 class Cache
 {
 	private $_obj = null;
 	private $_date = array();

 	public function __construct()
 	{
 		$config = Leguan::get('config');
 		$cacheType = $config->cacheType;
 		$cacheType = ucwords($cacheType);

 		$class = "\\Leguan\\Cache\\Adapter\\{$cacheType}";
 		$this->_obj = new $class();
 	}

 	/**
	 * 讀取緩存內容
	 *
	 * @param $name
	 * @return array
	 */
 	public function read($name)
 	{
 		if(!isset($this->_data[$name])){
 			$this->_data[$name] = $this->_obj->read($name);
 		}

 		return $this->_data[$name];
 	}

 	/**
	 * 写入緩存內容
	 *
	 * @param $name
	 * @param $value
	 * @return void
	 */
 	public function write($name, $value)
 	{
 		$this->_data[$name] = $value;
 		$this->_obj->write($name, $value);
 	}
 }