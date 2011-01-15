<?php

require_once ("Error.php");

class UserRemovedError extends Error{
		
	function __construct (){
		parent::__construct();
		$this->values = array(
			'code' => 'user_01',
			'message' => 'user removed from database',
		);
	}
}