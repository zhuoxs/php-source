<?php
define('IN_SYS', true);
require '../../framework/bootstrap.inc.php';
require '../../web/common/bootstrap.sys.inc.php';
global $_W,$_GPC;
$fhurl=explode("|",$_GPC['state']);
$weid=$fhurl[0];

//http://wx.youqi18.com/web/index.php?c=site&code=d9085cbce8073b33b5236a3fdc2c9e1c&state=renwubao
$siteroot = substr($_W['siteroot'], 0, stripos($_W['siteroot'], '/addons'));
$url = $siteroot.'/app/index.php';
$data = array('i'=>$weid,'c'=>'entry','do'=>'appqudaosq','m'=>'tiger_newhu','code'=>$_GPC['code'],'state'=>$_GPC['state']);
$query = http_build_query($data);
$url .= '?'.$query;
//echo $url;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$output = curl_exec($ch);
curl_close($ch);
//$output=json_decode($output,TRUE);
//echo "<pre>";
//print_r($output);
//exit;
$fh=$output;
if($fh=="OK"){
	$url=$url."?i=".$weid."&c=entry&do=msg&m=tiger_newhu&error=0";
  header("location:".$url);
}else{
	$url=$url."?i=".$weid."&c=entry&do=msg&m=tiger_newhu&error=1";
  header("location:".$url);
}

