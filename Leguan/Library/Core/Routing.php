<?php

class Routing extends LeguanBase{
	
	public function __construct(){
		$this->start();
	}

	public function start(){
		$controller = $this->Request->getInput('c');
		$action = $this->Request->getInput('a');
		$controller = $controller == null ? 'Index' : $controller;
		$action = $action == null ? 'Index' : $action;
		$controller = $controller."Controller";
		$action = $action."Action";
		$controller = new $controller();
		$controller->$action();
	}
}