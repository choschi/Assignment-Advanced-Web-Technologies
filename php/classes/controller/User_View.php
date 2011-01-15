<?php

class User_View extends View{

	private $modelFile = "model/User_Model.php";

	function __construct($options){
		parent::__construct($options);
		require_once ($this->modelFile);
		$this->model = new User_Model($options);
		$this->model->init();
	}
	public function display(){
		return $this->model->export();
	}
}