<?php

class LeguanBase{
	private static $_include = array();
	
	public function __get($class){
		$class = ucwords($class);
		if(!isset(LeguanBase::$_include[$class])){
			require $class.".php";
			LeguanBase::$_include[$class] = null;
		}
		if((isset($class::$isCache) && $class::$isCache === false)
			|| LeguanBase::$_include[$class] === null){
			LeguanBase::$_include[$class] = new $class();
		}
		return LeguanBase::$_include[$class];
	}
}