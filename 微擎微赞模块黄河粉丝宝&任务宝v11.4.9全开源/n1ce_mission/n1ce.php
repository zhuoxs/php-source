<?php
//
define('IN_SYS', true);
require '../../framework/bootstrap.inc.php';
require '../../web/common/bootstrap.sys.inc.php';
global $_W,$_GPC;
$siteroot = substr($_W['siteroot'], 0, stripos($_W['siteroot'], '/addons'));
$url = $siteroot.'/app/index.php';
$data = array('i'=>$_GPC['i'],'c'=>'entry','do'=>'shoptoken','m'=>'n1ce_mission','code'=>$_GPC['code'],'state'=>$_GPC['state']);
$query = http_build_query($data);
$url .= '?'.$query;
header("location:" . $url);
