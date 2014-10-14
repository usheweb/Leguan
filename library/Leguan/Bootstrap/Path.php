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
 * 路径信息类
 */
class Path
{
	//路径信息
	private $_path = array();

	public function __construct()
	{
		$this->_init();
	}

	/**
	 * 初始化路径信息
	 */
	private function _init()
	{
		$this->_path['root'] = realpath('');
		$this->_path['ds'] = DIRECTORY_SEPARATOR;
		$this->_path['ps'] = PATH_SEPARATOR;
		$this->_path['lib'] = $this->_path['root'] . $this->_path['ds'] . 'library';
		$this->_path['app'] = $this->_path['root'] . $this->_path['ds'] . APP_NAME;
		$this->_path['data'] = $this->_path['root'] . $this->_path['ds'] . 'data';
		$this->_path['view'] = $this->_path['root'] . $this->_path['ds'] . 'themes';
		$this->_path['upload'] = $this->_path['root'] . $this->_path['ds'] . 'uploads';

		$this->_path['cache'] = $this->_path['data'] . $this->_path['ds'] . 'cache';
		$this->_path['log'] = $this->_path['data'] . $this->_path['ds'] . 'log';

		$this->_path['html'] = $this->_path['cache'] . $this->_path['ds'] . 'html';
		$this->_path['data'] = $this->_path['cache'] . $this->_path['ds'] . 'data';

		$this->_path['appCommon'] = $this->_path['app'] . $this->_path['ds'] . 'Common';
		$this->_path['appConfig'] = $this->_path['appCommon'] . $this->_path['ds'] . 'Config';
	}

	public function __get($name)
	{
		if (isset($this->_path[$name])) {
			return $this->_path[$name];
		}

		return null;
	}

	public function __set($name, $value)
	{
		$this->add($name, $value);
	}

	/**
	 * 添加路径信息
	 *
	 * @exception $name路径信息存在
	 * @param $name string
	 * @param $value string
	 * @return void
	 */
	public function add($name, $value)
	{
		if (isset($this->_path[$name])) {
			throw new \Exception("$name".'已在Path::$_path中', 1);
		}

		$this->_path[$name] = $value;
	}

	/**
	 * 删除路径信息
	 *
	 * @exception $name路径信息不存在
	 * @param $name
	 * @return string
	 */
	public function del($name)
	{
		if(!isset($this->_path[$name])){
			throw new \Exception("$name".'不在Path::$_path中', 1);
		}

		unset($this->_path[$name]);
	}
	
	/**
	 * 清除路径信息
	 */
	public function clear()
	{
		$this->_path = array();
	}

	/**
	 * 获取路径中文件扩展名
	 */
	public function getExtension($path)
	{
		return pathinfo($path, PATHINFO_EXTENSION);
	}
}