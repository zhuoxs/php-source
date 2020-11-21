<?php


defined("IN_IA") or exit("Access Denied");
global $_W, $_GPC;
checklogin();
load()->func("tpl");
$op = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
$uniacid = $_W["uniacid"];
if ($op == "display") {
    $result=array(
      array('id'=>'soprano','name'=>'高音喇叭','price'=>'免费','image'=>'../addons/crad_qrcode_red/static/images/mic.png','description'=>'在线下活动时开启可以保养喉咙','version_now'=>'1.1.2','status_str'=>'<span class="label label-success">已下载</span>'),
      array('id'=>'superqrcode','name'=>'超级活码','price'=>'免费','image'=>'../addons/crad_qrcode_red/static/images/erweima.png','description'=>'兼容多个批次红包和外部链接的活码','version_now'=>'1.1.0','status_str'=>'<span class="label label-success">已下载</span>'),
      array('id'=>'adcenter','name'=>'广告中心','price'=>'免费','image'=>'../addons/crad_qrcode_red/static/images/ad.png','description'=>'在红包中投放广告','version_now'=>'1.1.0','status_str'=>'<span class="label label-success">已下载</span>'),

    );


    include $this->template("plugins");
    exit;
}
message("操作失败，请检查目录权限", referer(), "error");
