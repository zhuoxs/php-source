<?php
define('IN_SYS', true);
require '../../framework/bootstrap.inc.php';
require '../../web/common/bootstrap.sys.inc.php';
global $_W,$_GPC;
$siteroot = substr($_W['siteroot'], 0, stripos($_W['siteroot'], '/addons'));
$url = $siteroot.'/app/index.php';
$data = array('i'=>$_GPC['i'],'c'=>'entry','do'=>'tksign','m'=>'tiger_newhu','sign'=>$_GPC['sign'],'tbnickname'=>$_GPC['tbnickname'],'tbuid'=>$_GPC['tbuid'],'endtime'=>$_GPC['endtime']);
$query = http_build_query($data);
$url .= '?'.$query;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$output = curl_exec($ch);
curl_close($ch);
print_r($output);
