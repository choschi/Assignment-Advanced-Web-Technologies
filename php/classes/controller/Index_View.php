<?php

class Index_View extends View{

	private $view;
	
	function __construct($options){
		parent::__construct($options);
		$controllerFile = "classes/controller/";
		$className = ucfirst($_REQUEST['what'])."_";
		$controllerFile .= $className."View.php";
		$className .= "View";
		if (file_exists($controllerFile)){
			require_once $controllerFile;
			$this->view = new $className ($this->options);
		}else{
			require_once "controller/Missing_View.php";
			$this->view = new Missing_View($this->options);
		}
	}
	
	public function display(){
		switch ($this->options['form']){
			default:
			case "xml":
				header ("Content-Type: application/xml; charset=UTF-8");
			break;	
		}
		return $this->view->display();
	}
}