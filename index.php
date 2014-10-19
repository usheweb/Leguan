<?php
/**
 * leguan Framework 入口文件
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

define('IS_DEBUG', true);
define('APP_NAME', 'appliction');

require dirname(__FILE__)."/library/Leguan/Bootstrap/Start.php";
\Leguan\Bootstrap\Start::run();