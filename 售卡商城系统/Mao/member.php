<?php
if(!defined('IN_CRONLITE'))exit();

$my=isset($_GET['my'])?$_GET['my']:null;

$clientip=$_SERVER['REMOTE_ADDR'];

if(isset($_COOKIE["Mao_token"]))
{
	$token=authcode(daddslashes($_COOKIE['Mao_token']), 'DECODE', SYS_KEY);
	list($user, $sid) = explode("\t", $token);
	$session=md5($mao['user'].$mao['pass'].$password_hash);
	if($session==$sid) {
		$islogin=1;
	}
}
?>