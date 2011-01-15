<?php

class Module_Model extends Model{
    
	private $dataSets;
	
    public function init(){
		$manager = DataManager::getInstance();
		if (isset($_REQUEST['for'])){
			if (isset($_REQUEST['id'])){
				switch ($_REQUEST['for']){
					default:
					case "class":		
						$this->dataSets = $manager->getModulesForClass($_REQUEST['id']);
					break;
				}
			}
		}else{
			if (isset($_REQUEST['id'])){
				$this->dataSets = $manager->getModule($_REQUEST['id']);
			}else{
				$this->dataSets = $manager->getAllModules();
			}
		}
    }
	
	public function export(){
		switch ($this->options['form']){
			default:
			case "xml":
				$xml = new DOMDocument('1.0', 'utf-8');
				$root = $xml->createElement('modules');
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
