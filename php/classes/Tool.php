<?php

/**
* Tools is a collection of globaly usefull methods
*/

class Tool{
	
	/**
	* renders a markup template and replaces the variables with the provided data
	* @param path to template file
	* @param collection of variables
	* @return the rendered template markup
	*/
	
	public static function renderTemplate ($templateFile,$variables){
		$fileName = "template/".$templateFile;
		if (file_exists($fileName)){
		  $file = fopen($fileName,"r");
		  $template = fread($file,filesize($fileName));
		  fclose ($file);
		  $template = str_replace(array('---req###','---opt###'),array('###','###'),$template);
		  foreach ($variables as $name=>$value){
			  $template = str_replace('###'.$name.'###',$value,$template);
		  }
		  return $template;
		}else{
			return "";	
		}
	}
	
	/**
	* checks e-mails for compliance
	* @param e-mail address
	* @return true or false on invalidity
	*/
	
	public static function checkEmail($email){
		if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
			return true;
		}else{
			return false;
		}
	}
	
	/**
	* checks e-mails for compliance
	* @param e-mail address
	* @return true or false on invalidity
	*/
	
	public static function makeUtf8 ($value){
		if ( mb_detect_encoding ($value) != "UTF-8"){
			return utf8_encode($value);
		}else{
			return $value;	
		}
	}
	
	/**
	* answers to the question if the whole thing is in debug mode
	* @return true if in debug mode
	*/
	
	public static function isDebugging(){
		$config = Tool::getConfig();
		return $config['debug'];
	}
	
	/**
	* checks if a date really is a date unlike 29.02.2001 e.g.
	* @param day
	* @param month
	* @param year
	* @return true or false on invalidity
	*/
	
	public static function checkDate($day,$month,$year){
		if ($month < 8 && $month%2 == 0 && $day == 31){
			return false;
		}
		if ($month > 7 && $month%2 == 1 && $day == 31){
			return false;
		}
		if ($month == 2 && $day > 28){
			$four = $year % 4;
			$hundred = $year % 100;
			$fourhundred = $year % 400;
			if (($four == 0 && $hundred != 0) || ($hundred == 0 && $fourhundred == 0)){
				if ($day != 29){
					return false;
				}
			}else{
				return false;
			}
		}
		return true;
	}
	
	/**
	* returns an associative array which defines the variables used in a template
	* @param path to template file
	* @return associative array
	*/
	
	public static function createDefinitionFromTemplate($templateFile){
		$fileName = "template/".$templateFile;
		$file = fopen($fileName,"r");
		$template = fread($file,filesize($fileName));
		$variableTokens = explode("###",$template);
		$firstString = substr($template,0,3);
		$i = 1;
		if (strcmp($firstString,"") == 0){
			$i = 0;
		}
		$output = array();
		for ($i;$i<sizeof($variableTokens);$i+=2){
			$detailTokens = explode("---",$variableTokens[$i]);
			if (strcmp(strtolower($detailTokens[1]),'req') == 0){
				$output[$detailTokens[0]] = Model::REQUIRED;
			}else if (strcmp(strtolower($detailTokens[1]),'opt') == 0){
				$output[$detailTokens[0]] = Model::OPTIONAL;
			}else{
				throw new Exception ('Unrecognized Template Variable State');
			}
		}
		return $output;
	}
	
	/**
	* returns the list of css-files to include
	* @return associative array
	*/
	
	public static function getStylesheets (){
		$config = Tool::getConfig();
		return $config['css'];
	}
	
	/**
	* returns the list of meta tags to set
	* @return associative array
	*/
	
	public static function getMetaElements(){
		$config = Tool::getConfig();
		return $config['meta'];
	}
	
	/**
	* returns the list of javascript files to load
	* @return associative array
	*/
	
	public static function getJavascripts(){
		$config = Tool::getConfig();
		return $config['javascript'];
	}
	
	/**
	* returns the corresponding language string
	* @param identifier of the string
	* @return string in the actual language
	*/
	
	public static function getString($string){
		if (self::isDebugging()){
			$manager = DataManager::getInstance();
			$manager->saveI18NString($string);	
		}
		require_once ('i18n/'.Tool::getLanguage().'/Strings.php');
		$container = Strings::getInstance();
		$strings = $container->getStrings();
		if (isset($strings[$string])){
			return $strings[$string];
		}else{
			return $string;
		}
	}
	
	/**
	* returns an instance of the config tree
	* @return associative array
	*/
	
	public static function getConfig(){
		$config = Config::getInstance();
		return $config->getConfig();
	}
	
	/**
	* generates forms from a form definition array 
	*/
	
	public static function &generateForm($formDefinition,$name,$action,$submitCaption){
		require_once 'HTML/QuickForm.php';
		require_once 'HTML/QuickForm/radio.php';

		$form = new HTML_QuickForm($name,'post',$action,null,array('accept-encoding'=>'utf-8'));
		
		$form->setRequiredNote('<p class="formRequired"><span>*</span> '.Tool::getString('form_caption_required').'</p>');
		
		foreach ($formDefinition as $field=>$definition){
			switch ($definition['type']){
				case 'select':
					$select =& $form->createElement('select',$field,Tool::getString($name.'_caption_'.$field));
					$select->loadArray($definition['options']);
					$form->addElement ($select);
				break;
				default:
					$form->addElement ($definition['type'],$field,Tool::getString($name.'_caption_'.$field));
				break;
			}
			foreach ($definition['rules'] as $rule){
				$form->addRule ($field,Tool::getString('rule_caption_'.$rule),$rule,null,'client');
			}
		}
		
		$form->addElement('submit', null, $submitCaption);
		
		return $form;
	}
	
	
	/**
	* sets the include paths according to the config 
	*/
	
	public static function setIncludePaths(){
		$config = Tool::getConfig();
		set_include_path($config['includePaths']);
	}
	
	/**
	* sets the session language variable to a meaningfull value according to
	* actual state and user inpus
	*/
	
	public static function determineLanguage(){
		if (isset($_REQUEST['language'])){
			$_SESSION['siteLanguage'] = $_REQUEST['language'];
		}
		if (!isset($_SESSION['siteLanguage'])){
			$config = Tool::getConfig();
			$_SESSION['siteLanguage'] = $config['standardLanguage'];
		}
	}
	
	/**
	* returns an iso lang string e.g. de for german and en for english
	* @return string
	*/
	
	public static function getLanguage(){
		return $_SESSION['siteLanguage'];
	}
}
?>