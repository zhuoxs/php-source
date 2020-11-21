<?php

require_once './../../../framework/bootstrap.inc.php';

load()->func('communication');
load()->model('cloud');
load()->func('file');
load()->func('up');

$m = $_GPC['m'];
$path = $_GET['path'];

	$pathl = IA_ROOT;
	$hosturl = trim($_SERVER['HTTP_HOST']);
	$updatehost = UPDATEHOST;
    $updatedir = IA_ROOT.'/data/update';
    $back = date("Ymdhis");
	$backdir = IA_ROOT.'/data/patch'.'/'.$back.'/addons/'.$m;

if($_GET['type'] == 'file'){
  
  	$paths = array('file' => $path );
  	$file = SendCurl($updatehost.'?a=file&u='.$hosturl,$paths);
  	$filterl = file_back($pathl, $file, $backdir, $path);

	echo $filterl;
}

if($_GET['type'] == 'module'){
  	$mname = $_GET['mname'];
  	$pathl = IA_ROOT."/addons/".$mname;
  	$paths = array('file' => $path );
  	$file = SendCurl($updatehost.'?a=mfile&u='.$hosturl.'&m='.$mname,$paths);
  	$filterl = file_back($pathl, $file, $backdir, $path);

	echo $filterl;
}

if($_GET['type'] == 'db'){
  
	echo '1111';
}

if($_GET['type'] == 'del'){
  	$updatedir = $updatedir.'/map.json';
  	unlink($updatedir);
}
