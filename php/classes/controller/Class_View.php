<?php

class Class_View extends View{

	private $modelFile = "model/Class_Model.php";

	function __construct($options){
		parent::__construct($options);
		require_once ($this->modelFile);
		$this->model = new Class_Model($this->options);
		$this->model->init();
	}
	public function display(){
		return $this->model->export();
	}
}