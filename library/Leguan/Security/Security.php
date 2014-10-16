<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

 namespace Leguan\Security;

 /**
  * 安全处理类
  */
 class Security
 {
 	/**
	 * 递归方式的对变量中的特殊字符进行转义
	 * @link http://www.hankcs.com/program/addslashes_deep-fang-zhu-ru-bu-ding.html
	 *
	 * @access  public
	 * @param   mix     $value
	 * @return  mix
	 */
	public function addslashesDeep($value)
	{
	    if (empty($value)) {
	        return $value;
	    } else {
	        return is_array($value) ? array_map(array($this, 'addslashesDeep'), $value) : addslashes($value);
	    }
	}
 }