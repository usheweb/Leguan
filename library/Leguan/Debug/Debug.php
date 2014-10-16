<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\Debug;

use Leguan\Bootstrap\Leguan;

/**
 * 调试类
 */
class Debug
{
	private $_time = array();
	private $_memory = array();

	/**
	 * 变量调试输出
	 */
	public function dump($expression = null)
	{
		echo "<pre>";
		var_dump($expression);
		echo "</pre>";
	}

	/**
	 * 字符串输出到 textarea 中
	 */
	public function dumpText($string, $col = 150, $row = 50)
	{
		echo "<textarea cols={$col} rows={$row}>{$string}</textarea>";
	}

	/**
	 * 开始记录代码执行时间和内存
	 *
	 * @param $name string
	 * @return void
	 */
	public function start($name)
	{
		$this->_time[$name] = microtime(true);
		$this->_memory[$name] = memory_get_usage();
	}

	/**
	 * 停止记录
	 * 
	 * @param $name string
	 * @return float
	 */
	public function stop($name)
	{
		$this->_time[$name] = microtime(true) - $this->_time[$name];
		$this->_memory[$name] = memory_get_usage() - $this->_memory[$name];
		
		return number_format($this->_time[$name] , 3) . '秒 | ' . number_format($this->_memory[$name] / 1024 / 1024, 2) . "MB";
	}

	/**
	 * 获取代码执行时间
	 * 
	 * @param $name string
	 * @return float
	 */
	public function time($name)
	{
		return $this->_time[$name];
	}

	/**
	 * 获取代码使用内存
	 * 
	 * @param $name string
	 * @return float
	 */
	public function memory($name)
	{
		return $this->_memory[$name];
	}


	/**
	 * 获取app执行时间
	 *
	 * @return float
	 */
	public function appTime()
	{
		return microtime(true) - APP_START_TIME;
	}

	/**
	 * 获取内存使用情况
	 */
	public function appMemory()
	{
		return memory_get_usage() - APP_START_MEMORY;
	}

	/**
	 * 获取内存和事件使用情况
	 */
	public function appMsg()
	{
		return number_format($this->appTime() , 3) . '秒 | ' . number_format($this->appMemory() / 1024 / 1024, 2) . "MB";
	}

	/**
	 * 获取数据库查询次数
	 */
	public function getQueryNum()
	{
		$db = Leguan::get('db');

		return $db->getQueryNum();
	}

}