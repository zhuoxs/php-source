<?php

global $_W;
global $_GPC;
require ES_CORE_PATH . 'functions.php';
require ES_CORE_PATH . 'controller.php';
$controller = strtolower($controller);

if (empty($controller)) {
	$controller = ES_DEFAULT_CONTROLLER;
}

$action = strtolower($action);

if (empty($action)) {
	$action = ES_DEFAULT_ACTION;
}

$controller_file = ES_CONTROLLER_PATH . $controller . '.php';

if (!is_file($controller_file)) {
	es_empty();
	exit();
}

require $controller_file;
$class_name = ucfirst($controller) . 'Controller';
$class = new $class_name();

if (method_exists($class, $action)) {
	$class->$action();
	exit();
}

es_empty();
exit();

?>
