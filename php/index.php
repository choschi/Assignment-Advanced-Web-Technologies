<?php

session_start();

header ("Content-Type: text/xml; charset=UTF-8");
header ("Cache-Control: private");

ob_start("ob_gzhandler");

require_once "classes/Config.php";
require_once "classes/Tool.php";

Tool::setIncludePaths();
Tool::determineLanguage();

require_once "DataManager.php";
require_once "View.php";
require_once "Model.php";

$config = Config::getInstance();

if (isset($_REQUEST['view'])){
    if ($_REQUEST['view'] == 'admin'){
        $config->defineConfig(CONFIG_ADMIN);
        require_once "admin/controller/Index_View.php";
    }
}else{
    $config->defineConfig(CONFIG_PUBLIC);
    require_once "controller/Index_View.php";
}

$page = new Index_View($_REQUEST);

//print_r ($_REQUEST);

print $page->display();

