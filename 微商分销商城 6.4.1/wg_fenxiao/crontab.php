<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
define('IN_MOBILE', true);
require '../../framework/bootstrap.inc.php';
$input = file_get_contents('php://input');

$site = WeUtility::createModuleSite('wg_fenxiao');
$method = 'doMobilereceiveorder';
$result = $site->$method();
var_dump($result);
