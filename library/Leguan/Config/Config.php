<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

 namespace Leguan\Config;

/**
 * 配置文件管理类
 */
 class Config
 {
 	//配置信息
 	private $_config = array();

 	public function __construct()
 	{
 		$this->_init();
 	}

 	/**
 	 * 配置信息初始化
 	 */
 	private function _init()
 	{
 		$this->_config = require 'etc.php';
 	}

 	public function __get($name)
 	{
 		return $this->get($name);
 	}

 	public function __set($name, $value)
 	{
 		$this->set($name, $value);
 	}

 	/**
	 * 加载一组配置
	 *
	 * @param array $config 新的配置数组
	 * @return void
	 */
	public function load($config)
	{
		$this->_config = array_merge($this->_config,$config);
	}

	/**
	 * 获取系统配置
	 *
	 * @param string $name 配置的name
	 * @return mixed
	 */
	public function get($name)
	{
		if(!isset($this->_config[$name])){
			return null;
		}
		
		return $this->_config[$name];
	}

	/**
	 * 设置系统配置
	 *
	 * @param string $name 配置的name
	 * @param mixed $value 配置的值
	 * @return void
	 */
	public function set($name,$value)
	{
		$this->_config[$name] = $value;
	}

	/**
	 * 删除一个配置
	 *
	 * @param $name string
	 * @return void
	 */
	public function del($name)
	{
		if(!isset($this->_config[$name])){
			return null;
		}

		unset($this->_config[$name]);
	}
	
	/**
	 * 清除配置
	 */
	public function clear()
	{
		$this->_config = array();
	}
 }