<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\Bootstrap;

/**
 * leguan 核心控制类
 */
class Leguan
{
	//对象实例
	private static $_obj = array();

	/**
	 * 添加对象
	 *
	 * @exception $name已经存在
	 * @param $name string
	 * @param $obj mixed
	 * @return void
	 */
	public static function set($name, $obj)
	{
		$name = ucwords($name);
		if (isset(self::$_obj[$name])) {
			throw new \Exception("{$name}".'已在Leguan::$_obj中', 1);
		}

		self::$_obj[$name] = $obj;
	}

	/**
	 * 删除对象
	 * @exception $name不存在
	 * @param $name string
	 * @return void
	 */
	public static function del($name)
	{
		if (!isset(self::$_obj[$name])) {
			throw new \Exception("{$name}".'不在Leguan::$_obj中', 1);
		}

		unset(self::$_obj[$name]);
	}
	
	/**
	 * 清除对象
	 */
	public static function clear()
	{
		self::$_obj = array();
	}

	/**
	 * 获取对象
	 *
	 * @exception $name不存在
	 * @param $name string
	 * @return mixed
	 */
	public static function get($name)
	{
		$name = ucwords($name);
		if (!isset(self::$_obj[$name])) {
			$obj = "\\Leguan\\{$name}\\{$name}";
			self::$_obj[$name] = new $obj();
		}

		return self::$_obj[$name];
	}
}