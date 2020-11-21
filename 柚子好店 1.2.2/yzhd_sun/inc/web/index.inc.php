<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

//会员信息
$time=date("Y-m-d");
$time2=date("Y-m-d",strtotime("-1 day"));
$time3=date("Y-m");
//会员总数
$totalhy=pdo_get('yzhd_sun_user', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));

//今日新增会员
$sql=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('yzhd_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jir=count(pdo_fetchall($sql));

//昨日新增
$sql2=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('yzhd_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time2}%' ";
$zuor=count(pdo_fetchall($sql2));

//本月新增
$sql3=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('yzhd_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time3}%' ";
$beny=count(pdo_fetchall($sql3));

//商品一览
////商品总数
$goodstotal=count(pdo_getall('yzhd_sun_caipin', array('uniacid'=>$_W['uniacid'],'state'=>2)));

//新增商品
$sql4=" select a.* from (select  cid,FROM_UNIXTIME(create_time) as time  from".tablename('yzhd_sun_caipin')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jrgoods=count(pdo_fetchall($sql4));

//总共订单
$totalorder=pdo_get('yzhd_sun_order', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));

//待发货订单
$dfhorder=pdo_get('yzhd_sun_order', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));

//die;
include $this->template('web/index');