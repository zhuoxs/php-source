<?php
error_reporting(0);
session_start();
define('IN_CRONLITE', true);
define('SYSTEM_ROOT', dirname(__FILE__).'/');
define('ROOT', dirname(SYSTEM_ROOT).'/');

date_default_timezone_set("PRC");
$time = date("Y-m-d");
$times = date("Y-m-d H:i:s");

$dbconfig=array(
	'host' => 'localhost', //数据库服务器 localhost
	'port' => 3306, //数据库端口
	'user' => 'llk_7cf3_cn', //数据库用户名
	'pwd' => '4tin6fJzMcaDAhm3', //数据库密码
	'dbname' => 'llk_7cf3_cn' //数据库名
);

$tx_app_id = '2047155482';//腾讯验证ID
$tx_app_key = '05HwaZsJ6wvKD_3-2IG4_oA**';//腾讯验证KEY
$AppSecret = '7iisd1dyg0h3ntko6wkkzuoe8d37t5pa';//阿里云接口AppSecret
$houzhui = "llk.7cf3.cn";//分站后缀

include_once(SYSTEM_ROOT."db.class.php");
include_once(SYSTEM_ROOT."function.php");
$DB=new DB($dbconfig['host'],$dbconfig['user'],$dbconfig['pwd'],$dbconfig['dbname'],$dbconfig['port']);

$mao=$DB->get_row("select * from mao_data where url='{$_SERVER['HTTP_HOST']}' or url_1='{$_SERVER['HTTP_HOST']}' limit 1");
if(!$mao){
    exit(sysmsg("当前域名未被开通使用！"));
}
if($mao['time'] < $time){
    exit(sysmsg("网站已到期！"));
}

$mao_zz = $DB->get_row("select * from mao_data where id='1' limit 1");
$zz_yzf_id = $mao_zz['yzf_id'];
$zz_yzf_key = $mao_zz['yzf_key'];
$zz_yzf_url = $mao_zz['yzf_url'];




include_once(SYSTEM_ROOT."member.php");