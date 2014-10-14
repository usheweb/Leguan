<?php

class Config extends LeguanBase{
	private $_config = array();

	public function __construct(){
		$this->_config = require $this->Path->leguanCommon."\Config.php";
	}

	public function load($config){
		$this->_config = array_merge($this->_config,$config);
	}

	public function get($key){
		if(isset($this->_config[$key])){
			return $this->_config[$key];
		}
		return null;
	}

	public function set($key,$value){
		$this->_config[$key] = $value;
	}
}