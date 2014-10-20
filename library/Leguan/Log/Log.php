<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\Log;

use \Leguan\Log\ILog;
use \Leguan\Bootstrap\Leguan;

/**
 * 日志操作类
 */
class Log implements ILog
{
	//写入日志
	public function write($msg)
	{
		$path = Leguan::get('path');
		$fileName = $path->log . $path->ds . date('Ym') . $path->ds . date('d') .".txt";
		$dirName = dirname($fileName);

		if(!file_exists($dirName) && 
			   !mkdir($dirName, 0777, true)){
				    die("创建目录失败 {$cacheDir}");
		}

		$handle = fopen($fileName, 'w');
		fwrite($handle, date('Y-m-d H:i:s')." {$msg}\r\n");
		fclose($handle);
	}
}