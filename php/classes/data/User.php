<?php

require_once ("DbData.php");

class User extends DbData{
	
	private $values;
	
	function __construct ($id=0){
		parent::__construct($id,self::getTable());
		$values = array();
		$this->initFromDb();
	}
	
	public function initFromDb($data=null){
		if ($data != null){
			foreach (self::getDataDefinition() as $key=>$type){
				$this->values[$key] = $this->convert($data->$key,$type);	
			}
		}
	}
	
	public function convertTo ($type,$root=null){
		switch ($type){
			default:
			case 'xml':
				return $this->getXML($root);
			break;	
		}
	}
	
	private function getXML($xml){
		$super = $xml->createElement('user');
		foreach ($this->values as $key=>$value){
			$node = $xml->createElement($this->getTagForKey($key),$value);
			$super->appendChild($node);	
		}
		return $super;
	}
	
	
	
	public function getValue ($key){
		if (isset($this->values[$key])){
			return $this->values[$key];	
		}else{
			return null;	
		}
	}
	
	public static function getTable(){
		return "cours";	
	}
	
	private function getTagForKey($key){
		$tags = self::getTagDefinition();
		return $tags[$key];
	}
	
	public static function getDataDefinition (){
		return array(
			'id' => MYSQL_TEXT,
			'name' => MYSQL_TEXT,
		);
	}
	public static function getTagDefinition (){
		return array(
			'id' => 'id',
			'name' => 'name',
		);
	}
}