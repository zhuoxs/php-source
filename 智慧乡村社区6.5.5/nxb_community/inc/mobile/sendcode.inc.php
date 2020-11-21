<?php

global $_W,$_GPC;
$config=$this->module['config'];
require_once('Ucpaas.class.php');
require_once('serverSid.php');
$code=rand(1000,9999);
$mobile=$_GPC['mobile'];


$appid = $config['appid'];	//应用的ID，可在开发者控制台内的短信产品下查看
$templateid = $config['templateid'];    //可在后台短信产品→选择接入的应用→短信模板-模板ID，查看该模板ID
$param = $code; //多个参数使用英文逗号隔开（如：param=“a,b,c”），如为参数则留空
$mobile = $mobile;
$uid = "";

//存缓存
cache_write('code',$param);

echo $ucpass->SendSms($appid,$templateid,$param,$mobile,$uid);

?>