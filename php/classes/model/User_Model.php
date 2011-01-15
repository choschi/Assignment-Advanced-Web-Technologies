<?php

class User_Model extends Model{
    
	private $dataSets;
	//protected $options;
	
	function __construct($options){
		$this->options = $options;
	}
	
    public function init(){
		$manager = DataManager::getInstance();
		if (isset($this->options['action'])){
			switch ($this->options['action']){
				case "create":
					try{
						$this->dataSets = $manager->createUser ($this->options['value_1'],$this->options['value_2']);
					}catch (User_exception $ex){
						require_once "data/UserAlreadyError.php";
						$error = new UserAlreadyError();
						$error->initFromDb ($data);
						$this->dataSets = array($error);
					}
				break;
				case "login":
					$this->dataSets = $manager->loginUser ($this->options['value_1'],$this->options['value_2']);
				break;
				case "delete":
					try{
						$this->dataSets = $manager->removeUser ($this->options['value_1'],$this->options['value_2']);
					}catch (User_exception $ex){
						require_once "data/UserRemovedError.php";
						$error = new UserRemovedError();
						$error->initFromDb ($data);
						$this->dataSets = array($error);
					}
				break;
				case "add":
					try{
						$this->dataSets = $manager->addModule ($this->options['value_1'],$this->options['value_2']);
					}catch (User_exception $ex){
						require_once "data/ModuleAddedError.php";
						$error = new ModuleAddedError();
						$error->initFromDb ($data);
						$this->dataSets = array($error);
					}
				break;
				case "remove":
					try{
						$this->dataSets = $manager->removeModule ($this->options['value_1'],$this->options['value_2']);
					}catch (User_exception $ex){
						require_once "data/ModuleRemovedError.php";
						$error = new ModuleRemovedError();
						$error->initFromDb ($data);
						$this->dataSets = array($error);
					}
				break;
				case "module":
					$this->dataSets = $manager->modulesForUser ($this->options['value_1']);
				break;
			}
		}
    }
	
	public function export(){
		switch ($this->options['form']){
			default:
			case "xml":
				$xml = new DOMDocument('1.0', 'utf-8');
				$root = $xml->createElement('user');
				foreach ($this->dataSets as $set){
					$item = $set->convertTo ('xml',$xml);
					$root->appendChild($item);
				}
				$xml->appendChild($root);
				return $xml->saveXML();
			break;	
		}
	}
}

?>
