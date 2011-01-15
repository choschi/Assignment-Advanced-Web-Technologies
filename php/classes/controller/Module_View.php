<?php

class Module_View extends View{

	private $modelFile = "model/Module_Model.php";

	function __construct($options){
		parent::__construct($options);
		require_once ($this->modelFile);
		$this->model = new Module_Model($this->options);
		$this->model->init();
	}
	public function display(){
		return $this->model->export();
	}
}