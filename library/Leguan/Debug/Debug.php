<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\Debug;

/**
 * 调试类
 */
class Debug
{
	private $_time = array();

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
	 * 开始记录代码执行时间
	 *
	 * @param $name string
	 * @return void
	 */
	public function start($name)
	{
		$this->_time[$name] = microtime(true);
	}

	/**
	 * 获取代码执行时间
	 * 
	 * @param $name string
	 * @return float
	 */
	public function stop($name)
	{
		$this->_time[$name] = microtime(true) - $this->_time[$name];
		
		return $this->_time[$name];
	}

	/**
	 * 获取app执行时间
	 *
	 * @return float
	 */
	public function execTime()
	{
		return microtime(true) - APP_START_TIME;
	}
}