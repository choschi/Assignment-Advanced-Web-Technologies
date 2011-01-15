<?php

/**
* Basic Model class provides the basic model methods 
*/

class Model{
	
	protected $options;
	protected $definition;
	protected $templateVariables;
	const OPTIONAL = 'optional';
	const REQUIRED = 'required';
	
	/**
	* constructor
	* @param $template, path to the corresponding template file
	* @param $options, usually the necessary data for the model
	*/
	
	function __construct($template,$options=null){
		// commented the template stuff out co it's not necessary in this project
		//$this->definition = Tool::createDefinitionFromTemplate($template);
		$this->options = $options;
		//$this->templateVariables = array();
	}
	
	/**
	* method to call to get the data necessary to fill the corresponding template
	* @ return the list of variables to propagate the template
	" @ throws exceptions
	*/
	
	public function getListForTemplate(){
		try{
			$this->checkConstraints();
		}catch (Exception $ex){
			throw $ex;
		}
		return $this->templateVariables;
	}
	
	/**
	* abstract method to call to set a template variable directly
	* @ throws exception on failure
	*/
	
	public function setVariable($key,$value){
		if (isset($this->definition[$key])){
			$this->templateVariables[$key] = $value;
		}else{
			throw new Exception ($key.' udefined template variable in template');
		}
	}
	
	/**
	* abstract method to call to get the contents of a template variable
	* @ throws exception on unavailable template variable
	*/
	
	public function getVariable($key){
		if (isset($this->definition[$key])){
			return $this->templateVariables[$key];
		}else{
			throw new Exception ($key.' udefined template variable in template');
		}
	}
	
	
	private function checkConstraints(){
		foreach ($this->definition as $variable=>$constraint){
			if ($constraint === self::OPTIONAL){
				if (!isset($this->templateVariables[$variable])){
					$this->templateVariables[$variable] = '';
				}
			}else if ($constraint === self::REQUIRED){
				if (!isset($this->templateVariables[$variable])){
					throw new Exception ('Unset Template Variable '.$variable);
				}else{
					if (strlen ($this->templateVariables[$variable]) < 1){
						throw new Exception ('Empty Template Variable '.$varible);
					}
				}
			}
		}
		return true;
	}
}

?>