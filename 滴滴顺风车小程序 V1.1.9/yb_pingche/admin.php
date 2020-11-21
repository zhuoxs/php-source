<?php
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
define('BIND_MODULE','Admin');
define('APP_DEBUG',True);//开启调试模式 true， 建议开发阶段开启 部署阶段注释或者设为 false
define('APP_PATH','./App/');
require './ThinkPHP/ThinkPHP.php';
?>