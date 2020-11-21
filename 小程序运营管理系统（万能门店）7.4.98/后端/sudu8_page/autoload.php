<?php



spl_autoload_register(function($class){
    $filepath = str_replace("\\","/",MODULE_ROOT.'/'.$class.".php");

    include $filepath;

});