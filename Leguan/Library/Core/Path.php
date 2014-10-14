<?php
class Path{
	private $_all = array();

	public function __construct(){
		$this->_all['ds'] = DIRECTORY_SEPARATOR;
		$this->_all['ps'] = PATH_SEPARATOR;
		$this->_all['rootPath'] = $GLOBALS['_rootPath'];

		$this->_all['appPath'] = $GLOBALS['_appPath'];
		$this->_all['appName'] = $GLOBALS['_appName'];
		$this->_all['appView'] = $this->_all['appPath']."/View";
		$this->_all['appModel'] = $this->_all['appPath']."/Model";
		$this->_all['appController'] = $this->_all['appPath']."/Controller";
		$this->_all['appCommon'] = $this->_all['appPath']."/Common";

		$this->_all['leguanPath'] = $this->_all['rootPath']."/Leguan";
		$this->_all['leguanCommon'] = $this->_all['leguanPath']."/Common";
	}

	public function __get($key){
		if(isset($this->_all[$key])){
			return $this->_all[$key];
		}
		return null;
	}
}