<?php

class Index_Model extends Model{
	public function init(){
		require_once "Tool.php";
		require_once "controller/MetaElement_View.php";
		require_once "controller/StyleSheet_View.php";
		require_once "controller/Javascript_View.php";
		$this->addStyleSheets(Tool::getStylesheets());
		$this->addMetaElements(Tool::getMetaElements());
		$this->addJavascript(Tool::getJavascripts());
		$this->setVariable('siteTitle',Tool::getString('siteTitle'));
	}
	
	public function addStyleSheets($sheets){
		$sheetsMarkup = "";
		try{
			$sheetsMarkup = $this->getVariable('css');
		}catch (Exception $ex){}
		foreach ($sheets as $sheet){
			$sheetView = new StyleSheet_View($sheet);
			$sheetsMarkup .= $sheetView->display()."\n";
		}
		$this->setVariable('css',$sheetsMarkup);
	}
	
	public function addMetaElements($elements){
		$metaMarkup = "";
		try{
			$metaMarkup = $this->getVariable('meta');
		}catch (Exception $ex){}
		foreach ($elements as $element){
			$metaView = new MetaElement_View($element);
			$metaMarkup .= $metaView->display()."\n";
		}
		$this->setVariable('meta',$metaMarkup);
	}
	
	public function addJavascript($scripts){
		$scriptMarkup = "";
		try{
			$scriptMarkup = $this->getVariable('javascript');
		}catch (Exception $ex){}
		foreach ($scripts as $script){
			$scriptView = new Javascript_View($script);
			$scriptMarkup .= $scriptView->display()."\n";
		}
		$this->setVariable('javascript',$scriptMarkup);
	}
}

?>