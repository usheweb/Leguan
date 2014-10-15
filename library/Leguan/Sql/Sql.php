<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\Sql;

use \Leguan\Bootstrap\Leguan;

/**
 * sql控制类
 */
class Sql
{
	private $_obj;

	public function __construct()
	{
		$config = Leguan::get('config');
 		$dbEngine = $config->dbEngine;
 		$dbEngine = ucwords($dbEngine);

 		$class = "\\Leguan\\Sql\\Adapter\\{$dbEngine}";
 		$this->_obj = new $class();
	}

	public function __call($name, $arguments)
	{
		return call_user_func_array(array($this->_obj, $name), $arguments);
	}
}