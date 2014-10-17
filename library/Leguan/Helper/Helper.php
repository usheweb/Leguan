<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

 namespace Leguan\Helper;

use Leguan\Bootstrap\Leguan;

 /**
  * 辅助类
  */
 class Helper
 {
 	/**
 	 * 获取当前时间的年份 如 2014
 	 */
 	public function getYear()
 	{
 		return date('Y');
 	}

 	/**
 	 * 获取当前时间的月份 如 08
 	 */
 	public function getMonth()
 	{
 		return date('m');
 	}

 	/**
 	 * 获取当前时间在月份中的天数 如 08
 	 */
 	public function getDay()
 	{
 		return date('d');
 	}

 	/**
 	 * 获取当前时间的日期 如 2014-10-12
 	 */
 	public function getDate($glue = '-')
 	{
 		$format = array('Y', 'm', 'd');
 		$format = implode($glue, $format);
 		return date($format);
 	}

 	/**
 	 * 获取当前时间的时间 如 23:03:06
 	 */
 	public function getTime($glue = ':')
 	{
 		$format = array('H', 'i', 's');
 		$format = implode($glue, $format);
 		return date($format);
 	}

 	/**
 	 * 加载应用级别和模块级别帮助文件
 	 */
 	public function __call($name, $arguments)
 	{
 		static $obj = array();

 		$url = Leguan::get('url');
 		$helper = array('Common', $url->m);

 		foreach ($helper as $value) {
 			$helper = "\\{$value}\\Helper\\Helper";
	 		if (!isset($obj[$helper])) {
	 			$obj[$helper] = new $helper();
	 		}

	 		if (is_callable(array($obj[$helper], $name))) {
	 			return call_user_func_array(array($obj[$helper], $name), $arguments);
	 		}
 		}

 		return null;
 	}
 	
 }