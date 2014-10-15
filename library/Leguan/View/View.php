<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\View;

use \Leguan\Bootstrap\Leguan;

/**
 * 模板解析类
 */
class View
{
	private $_obj;

	public function __construct()
	{
		$config = Leguan::get('config');

		$class = "\\Leguan\\View\\Adapter\\{$config->viewEngine}\\Loader";
		$loader = new $class();
		$this->_obj = $loader->getView();
	}

	public function __get($name)
	{
		return $this->_obj->$name;
	}

	public function __set($name, $value)
	{
		return $this->_obj->$name = $value;
	}

	public function __call($name, $arguments)
	{
		return call_user_func_array(array($this->_obj, $name), $arguments);
	}

}
