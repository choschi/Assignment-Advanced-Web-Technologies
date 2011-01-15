<?php

/**
* Basic View class provides the basic methods 
*/

class View{
	
	protected $options;
	protected $model;
	
	/**
	* you can pass necessary variables to the constructor<br />
	* usually that'd be the contents of $_REQUEST
	* for specific classes you pass the corresponding data object
	*/
	
	function __construct($variables){
		$this->options = $variables;
	}
	
	/**
	* abstract method to call to get the views markup
	*/
	
	public function display(){}
	
}

?>