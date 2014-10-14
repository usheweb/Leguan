<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\Db;

/**
 * PDO dsn生成类
 */
class Dsn
{
	private $_dbPort;
	private $_dbEngine;
	private $_dbName;
	private $_host;

	public function __construct($engine, $host, $dbName, $port = null)
	{
		$this->_dbEngine = $engine;
		$this->_dbPort = $port;
		$this->_dbName = $dbName;
		$this->_host = $host;
	}

	/**
	 * 获取当前数据库引擎对应的dsn
	 *
	 *	@return string
	 */
	public function getDsn()
	{
		$engine = $this->_dbEngine;

		if (empty($this->_dbPort)) {
			return $this->$engine();
		} else {
			return $this->$engine($this->_dbPort);
		}
	}

	public function mysql($port = 3306)
	{
		return $this->_common($port);
	}

	public function cubrid($port = 33000)
	{
		return $this->_common($port);
	}

	/**
	 * 通用dsn构造器
	 */
	private function _common($port)
	{
		return "{$this->_dbEngine}:dbname={$this->_dbName};host={$this->_host};port={$port}";
	}
}