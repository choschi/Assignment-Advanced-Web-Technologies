<?php

define ('MYSQL_INTEGER',0);
define ('MYSQL_BOOLEAN',1);
define ('MYSQL_TEXT',2);

require_once "DataManager.php";

class DbData {

	protected $dbal;
	protected $id;
	protected $table;
	
	function __construct($id=0,$table=null){
		$this->dbal = DataManager::getInstance();
		$this->id = $id;
		$this->table = $table;	
	}
	
	public function saveToDb(){
		$query = $this->getSaveQuery();
		if (strlen($query) > 0){
			$this->dbal->save($query);
		}
	}
	
	protected function getSaveQuery() {
			
	}
	
	public function initFromDb($void){
		$data = $this->dbal->load($this->table,$this->id);
		return $data;
	}
	
	protected function quote($value,$type){
		switch ($type){
			case MYSQL_INTEGER:
			case MYSQL_BOOLEAN:
				return $this->dbal->quote($value,'integer');
			break;
			default:
				return $this->dbal->quote($value,'text');
			break;
		}
	}
	
	protected function generateUID(){
		return $this->dbal->getID ();	
	}
	
	protected function getStandardValue($type){
		switch ($type){
			case MYSQL_INTEGER:
			case MYSQL_BOOLEAN:
				return 0;
			break;
			default:
				return "";
			break;
		}
	}
	
	protected function convert ($value,$type){
		switch ($type){
			case MYSQL_INTEGER:
			case MYSQL_BOOLEAN:
				return (int)$value;
			break;
			default:
				return $value;
			break;
		}
	}
	
	public function getData(){
		return null;	
	}
	
	public static function getFormDefinition(){
		return array();
	}
	
	public static function getTable(){
		return "";
	}
	
	public static function getDataDefinition (){
		return array()	;
	}
}