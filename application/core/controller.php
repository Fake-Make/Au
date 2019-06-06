<?php

class Controller {
	
	public $model;
	public $view;
	public $host;
	
	function __construct()
	{
		$this->view = new View();
		$this->host = preg_replace("!/Au/.*!", "/Au", $_SERVER['REQUEST_URI']);
	}
	
	// действие (action), вызываемое по умолчанию
	function action_index()
	{
		// todo	
	}
}
