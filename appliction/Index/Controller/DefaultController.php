<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Index\Controller;

use \Leguan\Controller\Controller;

class DefaultController extends Controller
{
	/**
	 * 默认控制器处理方法
	 */
	public function DefaultAction()
	{
		echo "DefaultController DefaultAction";
	}
}