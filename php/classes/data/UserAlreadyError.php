<?php

require_once ("Error.php");

class UserAlreadyError extends Error{
		
	function __construct (){
		parent::__construct();
		$this->values = array(
			'code' => 'user_00',
			'message' => 'user already in database',
		);
	}
}