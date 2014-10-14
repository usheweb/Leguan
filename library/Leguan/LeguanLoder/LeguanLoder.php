<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\LeguanLoder;

use \Leguan\Bootstrap\Leguan;

/**
 * Leguan 内部类加载器
 */
class LeguanLoder
{
	public function __get($name)
	{
		return Leguan::get($name);
	}
}