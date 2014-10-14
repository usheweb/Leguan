<?php

class Model extends LeguanBase{
	private static $_db = null;
	private static $_db_charset = 'utf8';
	private static $_db_prefix = '';

	private $stmt = null;

	public function __construct(){
		if(empty(Model::$_db)){
			$db_dsn = $this->Config->get('db_dsn');
			$db_user = $this->Config->get('db_user');
			$db_pwd = $this->Config->get('db_pwd');

			Model::$_db_charset = $this->Config->get('db_charset') != null ? 
			$this->Config->get('db_charset') : Model::$_db_charset;
			Model::$_db_prefix = $this->Config->get('db_prefix');
			
			try {
			    Model::$_db = new PDO($db_dsn,$db_user,$db_pwd);
			    //禁用prepared statements的仿真效果
			    Model::$_db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				Model::$_db->exec("set names '".Model::$_db_charset."'");
			} catch (PDOException $e) {
			    echo 'Connection failed: ' . $e->getMessage();
			}
		}
		//echo $this->debug->getExecTime();
	}

	public function query($statement,$input = array()){
		$statement = str_replace("@_", Model::$_db_prefix, $statement);
		$this->stmt = Model::$_db->prepare($statement);
		$result = $this->stmt->execute($input);
		if($result === false){
			return false;
		}
		return $this->_fetchAll();
	}

	public function getLastInsertId(){
		return Model::$_db->lastInsertId();
	}

	private function _fetchAll($style = PDO::FETCH_ASSOC){
		return $this->stmt->fetchAll($style);
	}
}