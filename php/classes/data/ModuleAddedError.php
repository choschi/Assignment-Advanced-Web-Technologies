<?php

require_once ("Error.php");

class ModuleAddedError extends Error{
		
	function __construct (){
		parent::__construct();
		$this->values = array(
			'code' => 'user_11',
			'message' => 'module added to user',
		);
	}
}