<?php

require_once ("Error.php");

class ModuleRemovedError extends Error{
		
	function __construct (){
		parent::__construct();
		$this->values = array(
			'code' => 'user_12',
			'message' => 'module removed from user',
		);
	}
}