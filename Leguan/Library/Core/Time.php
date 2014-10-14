<?php

class Time{
	//单位 秒
	private $microsecond;
	private $second;
	public static $isCache = false;

	public function __construct(){
		$this->microsecond = microtime(true);
		$this->second = intval($this->microsecond);
	}

	//获取微秒
	public function getMicrosecond(){
		return $this->microsecond;
	}

	//获取秒
	public function getSecond(){
		return $this->second;
	}

	//获取日期时间
	public function getDateTime(){
		return $this->_getDate('Y-m-d H:i:s');
	}

	//获取日期
	public function getDate(){
		return $this->_getDate('Y-m-d');
	}

	//获取月份中的第几天，没有前导零
	public function getDay(){
		return $this->_getDate('j');
	}

	//获取数字表示的月份，没有前导零 
	public function getMonth(){
		return $this->_getDate('n');
	}

	//4位数字完整表示的年份
	public function getYear(){
		return $this->_getDate('Y');
	} 

	//格式化一个当前时间／日期
	private function _getDate($format){
		return date($format,$this->second);
	}
}