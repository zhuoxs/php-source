<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

//会员信息
$time=date("Y-m-d");
$time2=date("Y-m-d",strtotime("-1 day"));
$time3=date("Y-m");

// var_dump($time);
// var_dump($time2);
// var_dump($time3);
//会员总数
$totalhy=pdo_get('yzkm_sun_user', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));
// var_dump($_GPC);
//今日新增会员
$sql=" select a.* from (select  id,time as time  from".tablename('yzkm_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jir=count(pdo_fetchall($sql));

//昨日新增
$sql2=" select a.* from (select  id,time as time  from".tablename('yzkm_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time2}%' ";
$zuor=count(pdo_fetchall($sql2));

//本月新增
$sql3=" select a.* from (select  id,time as time  from".tablename('yzkm_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time3}%' ";
$beny=count(pdo_fetchall($sql3));

//商品一览
////商品总数
$goodstotal=pdo_get('yzkm_sun_goods', array('uniacid'=>$_W['uniacid'],'status'=>2), array('count(gid) as count'));

//新增商品
$sql4=" select a.* from (select  gid,selftime as time  from".tablename('yzkm_sun_goods')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jrgoods=count(pdo_fetchall($sql4));

//总共订单
$totalorder=pdo_get('yzkm_sun_order', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));
// var_dump($totalorder);
//代发货订单
$dfhorder=pdo_get('yzkm_sun_order', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));
// var_dump($dfhorder);
//
//资讯数量



include $this->template('web/index');