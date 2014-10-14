<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\Cookie;

/**
 * cookie操作类
 */
class Cookie
{

	/**
	 * 设置cookie
	 *
	 * @param $name string
	 * @param $value string
	 * @param $expire int -1 永久 0 临时
	 * @return void
	 */
	public function set($name, $value, $expire = 0)
	{
		if($expire == -1){
			$expire = time() + 60 * 60 * 24 * 365 * 100;
		}
		setcookie($name, $value, $expire);
	}

	/**
	 * 获取cookie
	 *
	 * @param $name
	 * @return string 
	 */
	public function get($name)
	{
		if(isset($_COOKIE[$name])){
			return $_COOKIE[$name];
		}

		return null;
	}

	/**
	 * 删除cookie
	 *
	 * @param $name
	 * @return void
	 */
	public function del($name)
	{
		if(isset($_COOKIE[$name])){
			setcookie($name,'',time() - 1);
		}
	}

	public function __get($name)
	{
		return $this->get($name);
	}

	public function __set($name, $value)
	{
		$this->set($name, $value);
	}
}