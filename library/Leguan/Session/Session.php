<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

 namespace Leguan\Session;

/**
 * session 操作类
 */
 class Session
 {
 	/**
 	 * 开启session
 	 */
 	public function start()
 	{
 		session_start();
 	}

 	/**
 	 * 暂停session
 	 */
 	public function pause()
 	{
 		session_write_close();
 	}

 	/**
 	 * 清空session
 	 */
 	public function clear()
 	{
 		$_SESSION = array();
 	}

 	/**
 	 * 销毁session
 	 */
 	public function destroy()
 	{
 		unset($_SESSION);
 		session_destroy();
 	}

 	/**
 	 * 获取session ID
 	 * 
 	 * @return string
 	 */
 	public function getId()
 	{
 		return session_id();
 	}

 	/**
 	 * 设置session ID
 	 *
 	 * @param $id string
 	 * @return void
 	 */
 	public function setId($id)
 	{
 		session_id($id);
 	}

 	/**
 	 * 获取session保存路径
 	 * 
 	 * @return string
 	 */
 	public function getPath()
 	{
 		return session_save_path();
 	}

 	/**
 	 * 设置session保存路径
 	 * 
 	 * @param $path string
 	 * @return void
 	 */
 	public function setPath($path)
 	{
 		session_save_path($path);
 	}

 	/**
 	 * 获取session
 	 *
 	 * @param $name string
 	 * @return mixed
 	 */
 	public function get($name)
 	{
 		if(isset($_SESSION[$name])){
 			return $_SESSION[$name];
 		}

 		return null;
 	}

 	/**
 	 * 设置session
 	 *
 	 * @param $name string
 	 * @param $value mixed
 	 * @return void
 	 */
 	public function set($name, $value)
 	{
 		$_SESSION[$name] = $value;
 	}

 	/**
 	 * 删除session
 	 *
 	 * @param $name
 	 * @return void
 	 */
 	public function del($name)
 	{
 		if(isset($_SESSION[$name])){
 			unset($_SESSION[$name]);
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