<?php

require_once ("DbData.php");

class Klasse extends DbData{
	
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
		$super = $xml->createElement('class');
		foreach ($this->values as $key=>$value){
			if ($key == "modules"){
				$tokens = explode(",",$value);
				$node = $xml->createElement($this->getTagForKey($key));
				if (sizeof($tokens) > 0){
					foreach ($tokens as $klasse){
						if (strlen($klasse) > 2){
							$item = $xml->createElement ('module',$klasse);
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
			'class' => MYSQL_TEXT,
			'division' => MYSQL_TEXT,
			'location' => MYSQL_TEXT,
			'modules' => MYSQL_TEXT,
		);
	}
	public static function getTagDefinition (){
		return array(
			'id' => 'id',
			'class' => 'name',
			'division' => 'division',
			'location' => 'location',
			'modules' => 'modules',
		);
	}
}