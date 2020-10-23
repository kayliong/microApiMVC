<?php
// to load composer installed package
require __DIR__ . '/vendor/autoload.php';

// app directory
define('APPDIR' , dirname(__FILE__));
// debug
define('DEBUG', false);

//set env var
if(isset($_SERVER['ENVIRONMENT'])){
    define('ENVIRONMENT', $_SERVER['ENVIRONMENT']);
}else{
    define('ENVIRONMENT', "LOCAL");
}

// control the routing by env
switch (ENVIRONMENT){
    case "LOCAL":
        define('ROUTE_PREFIX', '/');
        break;
    default:
        define('ROUTE_PREFIX', '/');
}

spl_autoload_register(function($class_name) {
    // get the class type
 
    // check class is helper
    if (is_file(APPDIR.'/library/helper/'.$class_name.'.php')) {
        include_once APPDIR.'/library/helper/'.$class_name.'.php';
    }
    // check class is service
    elseif (is_file(APPDIR.'/models/service/'.$class_name.'.php')) {
        include_once APPDIR.'/models/service/'.$class_name.'.php';
    }
    // check class is service
    elseif (is_file(APPDIR.'/models/dao/'.$class_name.'.php')) {
        include_once APPDIR.'/models/dao/'.$class_name.'.php';
    }
    // check class file exist to load
    elseif(is_file(APPDIR.'/classes/'.strtolower($class_name).'.php')){
        include_once APPDIR.'/classes/'.strtolower($class_name).'.php';
    }
    // check class file exist to load
    elseif(is_file(APPDIR.'/controller/'.$class_name.'.php')){
        include_once APPDIR.'/controller/'.$class_name.'.php';
    }
    // check library base
    elseif (is_file(APPDIR.'/library/base/'.$class_name.'.php')) {
        include_once APPDIR.'/library/base/'.$class_name.'.php';
    }
    // class library core
    elseif (is_file(APPDIR.'/library/core/'.$class_name.'.php')) {
        include_once APPDIR.'/library/core/'.$class_name.'.php';
    }
    // class library hlper
    elseif (is_file(APPDIR.'/library/helper/'.$class_name.'.php')) {
        include_once APPDIR.'/library/helper/'.$class_name.'.php';
    }
});
