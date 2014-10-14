<?php
class Debug extends LeguanBase{
	public function dump($expression = null){
		echo "<pre>";
		var_dump($expression);
		echo "</pre>";
	}

	public function getExecTime(){
		return $this->Time->getMicrosecond() - $GLOBALS['_startTime'];
	}
}