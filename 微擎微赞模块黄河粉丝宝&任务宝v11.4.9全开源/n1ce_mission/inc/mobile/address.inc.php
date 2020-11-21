<?php
global $_W,$_GPC;
$rid = $_GPC['rid'];
$gid = $_GPC['gid'];
$from_user = $_GPC['from_user'];
//获取商品信息
$goods = pdo_fetch("select * from " .tablename('n1ce_mission_goods'). " where id = :id",array(':id'=>$gid));

if($goods['quality'] <= 0){
	message('手太慢, 已经兑换一空', referer(), 'error');
}
include $this->template('n1ce_address');