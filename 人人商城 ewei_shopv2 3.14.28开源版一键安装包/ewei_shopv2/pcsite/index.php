<?php

require '../framework/bootstrap.inc.php';
load()->web('common');
load()->web('template');
global $_W;
global $_GPC;
define('ES_PATH', str_replace('\\', '/', dirname(__FILE__)) . '/');
define('ES_CORE_PATH', ES_PATH . 'core/');
define('ES_CONTROLLER_PATH', ES_PATH . 'controller/');
define('ES_TEMPLATE_PATH', ES_PATH . 'template/');
define('ES_ROOT', '../addons/ewei_shopv2/');
define('ES_URL', $_W['siteroot']);
define('ES_SCRIPT_NAME', $_W['script_name']);
define('ES_CLIENT_IP', $_W['clientip']);
define('ES_STYLE', 'default');
define('ES_DEFAULT_CONTROLLER', 'home');
define('ES_DEFAULT_ACTION', 'index');
define('ES_EMPTY_CONTROLLER', 'empty');
require './core/bootstrap.php';
exit();

?>
