<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\View\Adapter\Leguan;

use \Leguan\View\ILoader;
use \Leguan\View\Adapter\Leguan\View;

/**
 * 视图加载器
 */
class Loader implements ILoader
{
	private $_obj;

	public function __construct()
	{
		$this->_obj = new view();

		//初始化模板引擎

	}

	public function getView()
	{
		return $this->_obj;
	}
}