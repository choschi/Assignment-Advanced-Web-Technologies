<?php

/**
* Config holds the configuration data
* To prevent multiple instantiation the singleton pattern was used
*/

define ('CONFIG_PUBLIC',1);
define ('CONFIG_ADMIN',2);

class Config{

	static private $instance = null;
	private $configPublic;
	private $configAdmin;
	private $type;

	
/**
* Returns the instance of Config
* @return the singleton instance of Config
*/
	
	
	static public function getInstance(){
		if (null === self::$instance){
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	public function defineConfig($cfg=CONFIG_PUBLIC){
		$this->type = $cfg;
	}
	
	public function getConfig(){
		switch ($this->type){
			case CONFIG_ADMIN:
				return $this->configAdmin;
			break;
			default:
				return $this->configPublic;
			break;
		}
		
	}


	private function __construct(){
		
		
		$this->configPublic = array(
			'debug' => true,
			'includePaths' => ".:".$_SERVER['DOCUMENT_ROOT'].":/".$_SERVER['DOCUMENT_ROOT']."/pear".":/".$_SERVER['DOCUMENT_ROOT']."/classes",
			'db' => array(
				'server' =>'choschi.mysql.db.internal',
				'database' => 'choschi_awt',
				'user' => 'username',
				'password' => 'password',
			),
		);
	}
}