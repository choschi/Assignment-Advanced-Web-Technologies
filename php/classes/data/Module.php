<?php

require_once ("DbData.php");

class Module extends DbData{
	
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
		$super = $xml->createElement('module');
		foreach ($this->values as $key=>$value){
			if ($key == "klassen"){
				$tokens = explode(",",$value);
				$node = $xml->createElement($this->getTagForKey($key));
				if (sizeof($tokens) > 0){
					foreach ($tokens as $klasse){
						if (strlen($klasse) > 0){
							$item = $xml->createElement ('class',$klasse);
							$node->appendChild ($item);	
						}
					}
				}
				$super->appendChild($node);
			}else{
				$node = $xml->createElement($this->getTagForKey($key),$value);
				$super->appendChild($node);	
			}
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
			'id' => MYSQL_INTEGER,
			'klassen' => MYSQL_TEXT,
			'start' => MYSQL_TEXT,
			'end' => MYSQL_TEXT,
			'day' => MYSQL_INTEGER,
			'lection' => MYSQL_INTEGER,
			'module' => MYSQL_TEXT,
			'name_de' => MYSQL_TEXT,
			'name_fr' => MYSQL_TEXT,
			'location' => MYSQL_TEXT,
			'durchfuehrung' => MYSQL_TEXT,
		);
	}
	public static function getTagDefinition (){
		return array(
			'id' => 'id',
			'klassen' => 'classes',
			'start' => 'start_time',
			'end' => 'end_time',
			'day' => 'day_of_week',
			'lection' => 'lection_id',
			'module' => 'shortname',
			'name_de' => 'name_de',
			'name_fr' => 'name_fr',
			'location' => 'location',
			'durchfuehrung' => 'execution',
		);
	}
}