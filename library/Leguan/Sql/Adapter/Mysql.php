<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\Sql\Adapter;

use Leguan\Bootstrap\Leguan;

 class Mysql
 {
 	//表名
 	private $_table = '';
 	//查询条件
 	private $_where = array();
 	//查询的字段名称
 	private $_field = array();
 	//新增的数据
 	private $_values = array();
 	//字段 表转义
 	private $_escape = array('','');
 	//限制操作数
 	private $_limit = '';

 	private $_db = null;

 	//预处理数据
 	protected $_input = array();

 	public function __construct()
 	{
 		$config = Leguan::get('config');
 		$dbEngine = ucwords($config->dbEngine);
 		$escape = "dbEscape{$dbEngine}";

 		if($config->$escape !== null){
 			//设置表、字段转义字符
 			$this->_escape = $config->$escape;
 		}

 		$this->_db = Leguan::get('db');
 	}

 	protected function _init()
 	{
 		$this->_where = array();
 		$this->_field = array();
 		$this->_values = array();
 		$this->_input = array();
 		$this->_table = '';
 	}

 	/**
 	 * 加添where条件数组
 	 *
 	 * @param $condition array
 	 * @return void
 	 */
 	public function where($condition)
 	{
 		$this->_where = array_merge($this->_where, $condition);

 		return $this;
 	}

 	/**
 	 * 添加查询的字段信息
 	 *
 	 * @param $fields
 	 * @return void
 	 */
 	public function field($fields)
 	{
 		$this->_field = $fields;

 		return $this;
 	}

 	/**
 	 * 添加新增的数据
 	 *
 	 * @param $values
 	 * @return void
 	 */
 	public function values($values)
 	{
 		$this->_values = array_merge($this->_values, $values);

 		return $this;
 	}

 	/**
 	 * 设置操作的表名
 	 *
 	 * @param $table
 	 * @return void
 	 */
 	public function table($table)
 	{
 		$this->_table = $table;

 		return $this;
 	}

 	/**
 	 * 获取添加数据的sql
 	 */
 	public function add($isQuery = true)
 	{
 		$sql = "insert into ". $this->_save() . ";";

 		if ($isQuery) {
 			return $this->_db->query($sql, $this->_input);
 		}

 		return $sql;
 	}

 	/**
 	 * 限制操作数
 	 */
 	public function limit($limit)
 	{
 		$this->_limit = $limit;
 	}

 	/**
 	 * 获取新增和修改 公共部分sql
 	 */
 	private function _save()
 	{
 		if(empty($this->_values)){
 			return '';
 		}

 		$values = '';
 		foreach ($this->_values as $key => $value) {
 			array_push($this->_input, $value);
 			$values .= "{$this->_escape[0]}". $this->filter($key) ."{$this->_escape[1]} = ?,";
 		}
 		$values = rtrim($values,','); 

 		return "{$this->_escape[0]}@_{$this->_table}{$this->_escape[1]} set {$values}";
 	}

 	/**
 	 * 获取删除数据的sql
 	 */
 	public function del($isQuery = true)
 	{
 		//防止意外删除全部数据
 		if(empty($this->_where)){
 			return '';
 		}

 		return $this->delAll($isQuery);
 	}

 	/**
 	 * 删除全部数据
 	 */
 	public function delAll($isQuery = true)
 	{
 		$sql = "delete @_{$this->_table} where ".$this->_where().";";

 		if ($isQuery) {
 			return $this->_db->query($sql, $this->_input);
 		}

 		return $sql;
 	}

 	/**
 	 * 获取修改数据的sql
 	 */
 	public function update($isQuery = true)
 	{
 		//防止意外修改全部数据
 		if(empty($this->_where)){
 			return '';
 		}

 		return $this->updateAll($isQuery);
 	}

 	/**
 	 * 修改全部数据
 	 */
 	public function updateAll($isQuery = true)
 	{
 		$sql = "update " . $this->_save() . " where " . $this->_where() .";";

 		if ($isQuery) {
 			return $this->_db->query($sql, $this->_input);
 		}

 		return $sql;
 	}

 	/**
 	 * 获取查询数据的sql
 	 */
 	public function select($isQuery = true)
 	{
 		$fields = '';
 		if (empty($this->_field)) {
 			$fields = '*';
 		} elseif (is_array($this->_field)) {
 			foreach ($this->_field as $value) {
 				$fields .= "{$this->_escape[0]}{$value}{$this->_escape[1]},";
 			}

 			$fields = rtrim($fields, ',');
 		} else {
 			$fields = $this->_field;
 		}

 		$sql = "select {$fields} from @_{$this->_table} where ".$this->_where();
 		if (!empty($this->_limit)) {
 			$sql .= " limit {$this->_limit}";
 		}
 		$sql = "{$sql};";

 		if ($isQuery) {
 			return $this->_db->query($sql, $this->_input);
 		}

 		return $sql;
 	}

 	/**
 	 * 获取where条件字符串
 	 * 
 	 * @return string
 	 */
 	private function _where()
 	{
 		if(empty($this->_where)){
 			return '1=1';
 		}

 		$where = '';
 		//array('age' => array('>','20','or')) == or age > 20
 		foreach ($this->_where as $key => $value) {
 			$condition = isset($value[2]) ? strtolower($value[2]) : 'and';
 			$operator = is_array($value) ? $value[0] : '=';
 			$placeholder = '?';

 			//in (?,?,?)
 			if ($operator == 'in') {
 				$placeholder = '(';
 				foreach ($value[1] as $in) {
 					$placeholder .= "?,";
 					array_push($this->_input, $in);
 				}
 				$placeholder = rtrim($placeholder,',');
 				$placeholder .= ')';
 			} else {
 				if (is_array($value)) {
	 				array_push($this->_input, $value[1]);
	 			} else {
	 				array_push($this->_input, $value);
	 			}
 			}

 			$where .= " {$condition} {$this->_escape[0]}". $this->filter($key) ."{$this->_escape[1]} {$operator} {$placeholder}";
 		}

 		$where = ltrim($where, ' and ');
 		$where = ltrim($where, ' or ');

 		return $where;
 	}

 	/**
 	 * key过滤
 	 */
 	public function filter($key)
 	{
 		if(preg_match("|^[0-9a-zA-Z_]*$|", $key)){
 			return $key;
 		}

 		return '';
 	}
 }