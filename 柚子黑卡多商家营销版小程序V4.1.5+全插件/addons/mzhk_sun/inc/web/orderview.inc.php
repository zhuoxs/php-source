<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$seetype = intval($_GPC["seetype"]);//0抢购，1拼团，2砍价，3集卡，4普通，5免单
$id = intval($_GPC["id"]);
if($id<=0){
    message('参数错误！','','error');
}
$where = " WHERE o.uniacid=".$_W['uniacid'];
$title = "";
$refund = array("否","退款申请中","已退款","拒绝退款");
if($seetype==1){
    $where .= " and o.id=".$id;
    $status_str = array("","取消订单","待支付","已支付","已成团","已完成","待收货");
    $title = "拼团订单";
    $sql = "select o.*,o.id as oid,u.name as uname from ".tablename('mzhk_sun_ptgroups')." as o left join ".tablename('mzhk_sun_user')." as u on u.openid=o.openid ";
}elseif($seetype==2){
    $where .= " and o.oid=".$id;
    $status_str = array("","取消订单","待支付","待使用","待收货","已完成");
    $title = "砍价订单";
    $sql = "select o.*,u.name as uname from ".tablename('mzhk_sun_kjorder')." as o left join ".tablename('mzhk_sun_user')." as u on u.openid=o.openid ";
}elseif($seetype==3){
    $where .= " and o.id=".$id;
    $status_str = array("待使用","待使用","已完成");
    $title = "集卡订单";
    $sql = "select o.*,o.id as oid,u.name as uname from ".tablename('mzhk_sun_cardorder')." as o left join ".tablename('mzhk_sun_user')." as u on u.openid=o.openid ";
}elseif($seetype==4){
    $where .= " and o.oid=".$id;
    $status_str = array("","取消订单","待支付","待使用","待收货","已完成");
    $title = "普通订单";
    $sql = "select o.*,u.name as uname from ".tablename('mzhk_sun_order')." as o left join ".tablename('mzhk_sun_user')." as u on u.openid=o.openid ";
}elseif($seetype==5){
    $where .= " and o.oid=".$id;
    $status_str = array("待使用","待使用","已完成");
    $title = "免单订单";
    $sql = "select o.*,u.name as uname from ".tablename('mzhk_sun_hyorder')." as o left join ".tablename('mzhk_sun_user')." as u on u.openid=o.openid ";
}else{
    $where .= " and o.oid=".$id;
    $status_str = array("","取消订单","待支付","待使用","待收货","已完成");
    $title = "抢购订单";
    $sql = "select o.*,u.name as uname from ".tablename('mzhk_sun_qgorder')." as o left join ".tablename('mzhk_sun_user')." as u on u.openid=o.openid ";
}
$sql = $sql.$where;

$info = pdo_fetch($sql,$data);
$info = array_change_key_case($info);//将数组键值


include $this->template('web/orderview');