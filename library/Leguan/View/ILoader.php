<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\View;

/**
 * 模板引擎加载类接口
 */
interface ILoader
{
	//获得模板引擎实例
	public function getView();
}