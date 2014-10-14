<?php

class View extends LeguanBase{
	private $_data = array();
	private $_view = '';

	public function clear(){
		$this->_data = array();
	}

	public function get($key){
		if(isset($this->_data[$key])){
			return $this->_data[$key];
		}
		return null;
	}

	public function set($key,$value){
		$this->_data[$key] = $value;
	}

	public function display($view = null){
		if($view != null){
			$this->setTemplate($view);
		}
		require $this->Path->appView."/{$this->_view}.php";
	}

	public function setTemplate($view){
		$this->_view = $view;
	}
}