<?php
	
/**
*框架引导文件
**/
class App extends LeguanBase{

	//设置异常处理
	public function __construct(){
		$this->LeguanException;
		$this->Routing;
	}
}

