<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\Cache\Adapter;

use \Leguan\Cache\ICache;
use \Leguan\Bootstrap\Leguan;

/**
 * 文件緩存類
 */
class File implements ICache
{
	/**
	 * 讀取緩存內容
	 *
	 * @param $name
	 * @return array
	 */
	public function read($name)
	{
		$path = Leguan::get('path');
		$fileName = $path->cache . $path->ds . "{$name}.php";
		
		if(file_exists($fileName)){
			$content = require $fileName;
			//http://www.cnblogs.com/A-Song/archive/2011/12/13/2285619.html
			if(get_magic_quotes_gpc()){
				$content = stripslashes($content);
			}
			return unserialize($content);
		}

		return null;
	}

	/**
	 * 写入緩存內容
	 *
	 * @param $name
	 * @param $value
	 * @return void
	 */
	public function write($name, $value)
	{
		$path = Leguan::get('path');
		$fileName = $path->cache . $path->ds . "{$name}.php";

		$data = "<?php
		return '".serialize($value)."';";

		file_put_contents($fileName, $data);
	}
}