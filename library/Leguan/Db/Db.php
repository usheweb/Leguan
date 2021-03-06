<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\Db;

use \Leguan\Bootstrap\Leguan;
use \Leguan\Db\Dsn;

/**
 * 数据库操作类
 */
class Db
{
	private static $_db = null;
	private static $_dbCharset = 'utf8';
	private static $_dbPrefix = '';
	private static $_queryNum = 0;

	private $stmt = null;

	public function __construct()
	{
		$this->_init();
	}

	/**
	 * 初始化数据库连接信息
	 */
	protected function _init()
	{
		$config = Leguan::get('config');

		if(empty(self::$_db)){

			self::$_dbCharset = $config->charset != null ? 
								 $config->charset : self::$_dbCharset;
			self::$_dbCharset = str_replace('-', '', self::$_dbCharset);
			self::$_dbPrefix = $config->dbPrefix;
			
			if(empty($config->dbDsn)){
				$dsn = new Dsn($config->dbEngine, 
					           $config->dbHost,
					           $config->dbName,
					           $config->dbPort);
				$config->dbDsn = $dsn->getDsn();
			}

			try {
			    self::$_db = new \PDO($config->dbDsn, $config->dbUser, $config->dbPwd);
			    //禁用prepared statements的仿真效果
			    self::$_db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
				self::$_db->exec("set names '".self::$_dbCharset."'");
			} catch (PDOException $e) {
			    echo 'Connection failed: ' . $e->getMessage();
			}
		}
	}

	/**
	 * 执行一条sql查询语句
	 *
	 * @param $statement string 带预处理的sql语句
	 * @param $input array 预处理数据
	 * @return mixed
	 */
	public function query($statement, $input = array())
	{
		$this->_prepare($statement);
		$result = $this->_stmt->execute($input);

		if($result === false){
			return false;
		}

		return $this->_fetchAll();
	}

	/**
	 * 执行一条update语句
	 */
	public function exec($statement, $input = array())
	{
		$this->_prepare($statement);
		return $this->_stmt->execute($input);
	}

	/**
	 * 执行一条预处理语句
	 */
	private function _prepare($statement)
	{
		$statement = str_replace("@_", self::$_dbPrefix, $statement);
		$this->_stmt = self::$_db->prepare($statement);

		//记录查询次数
		self::$_queryNum ++;
	}

	/**
	 * 获取最后插入记录的自增长id
	 */
	public function getLastInsertId()
	{
		return self::$_db->lastInsertId();
	}

	/**
	 * 开启事务
	 */
	public function beginTransaction()
	{
		return self::$_db->beginTransaction();
	}

	/**
	 * 事务回滚
	 */
	public function rollBack()
	{
		return self::$_db->rollBack();
	}

	/**
	 * 提交事务
	 */
	public function commit()
	{
		return self::$_db->commit();
	}

	/**
	 * 获取结果集
	 *
	 * @param $style
	 */
	private function _fetchAll($style = \PDO::FETCH_ASSOC)
	{
		return $this->_stmt->fetchAll($style);
	}

	/**
	 * 获取数据库查询次数
	 */
	public function getQueryNum()
	{
		return self::$_queryNum;
	}

}