<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

//会员信息
$time=date("Y-m-d");
$time2=date("Y-m-d",strtotime("-1 day"));
$time3=date("Y-m");
//会员总数
$totalhy=pdo_get('chbl_sun_user', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));
//今日新增会员
$sql=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('chbl_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jir=count(pdo_fetchall($sql));
//昨日新增
$sql2=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('chbl_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time2}%' ";
$zuor=count(pdo_fetchall($sql2));
//本月新增
$sql3=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('chbl_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time3}%' ";
$beny=count(pdo_fetchall($sql3));
$vip_totalprice = pdo_getcolumn('chbl_sun_vipcard',array('uniacid'=>$_W['uniacid']),'totalprice');
//商品一览
//商品总数
$goodstotal=pdo_get('chbl_sun_goods', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));
//新增商品
$sql4=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('chbl_sun_goods')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jrgoods=count(pdo_fetchall($sql4));
//总共订单
$totalorder=pdo_get('chbl_sun_order', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));
//代发货订单
$dfhorder=pdo_get('chbl_sun_order', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));

//帖子数量
$tztotal=pdo_get('chbl_sun_information', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));
//商户数量
$shtotal=pdo_get('chbl_sun_store', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));
//拼车数量
$pctotal=pdo_get('chbl_sun_car', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));

//资讯数量
$zxtotal=pdo_get('chbl_sun_zx', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));

//数据概况
//今日新增帖子
$sql5=" select a.* from (select  id,hb_money,hb_num,hb_type,hb_random,FROM_UNIXTIME(sh_time) as time  from".tablename('chbl_sun_information')." where uniacid={$_W['uniacid']} and state=2) a where time like '%{$time}%' ";
$tzinfo=pdo_fetchall($sql5);
$jrtz=count($tzinfo);
//今日新增头条
$sqltt = ' SELECT * FROM ' . tablename('chbl_sun_zx') . ' WHERE' . ' uniacid=' . $_W['uniacid'] . ' AND' . " time like '%{$time}%' ";
$ttinfo=pdo_fetchall($sqltt);
$jrtt=count($ttinfo);

//今日新增商户
$sh = pdo_getall('chbl_sun_store_active',array('uniacid'=>$_W['uniacid']));
foreach ($sh as $k=>$v){
    $sh[$k]['rz_time'] = date("Y-m-d",$v['rz_time']);
    $yestoday = date("Y-m-d",strtotime("-1 day"));
    if($sh[$k]['rz_time'] < $yestoday) unset($sh[$k]);
}
$jrsh=count($sh);
//今日砍价金额
$kanjia = pdo_getall('chbl_sun_order',array('uniacid'=>$_W['uniacid'],'out_trade_no'=>1));
$kanjiaprice = 0;
foreach ($kanjia as $k=>$v){
    if($kanjia[$k]['pay_time'] == 0) unset($kanjia[$k]);
    $kanjia[$k]['pay_time'] = date("Y-m-d",$v['pay_time']);
    $yestoday = date("Y-m-d",strtotime("-1 day"));
    if($kanjia[$k]['pay_time'] < $yestoday) unset($kanjia[$k]);
    $kanjiaprice += $kanjia[$k]['money'];
}

//今日拼团金额
$groups = pdo_getall('chbl_sun_order',array('uniacid'=>$_W['uniacid'],'out_trade_no'=>2));
$groupsprice = 0;
foreach ($groups as $k=>$v){
    if($groups[$k]['pay_time'] == 0) unset($groups[$k]);
    $groups[$k]['pay_time'] = date("Y-m-d",$v['pay_time']);
    $yestoday = date("Y-m-d",strtotime("-1 day"));
    if($groups[$k]['pay_time'] < $yestoday) unset($groups[$k]);
    $groupsprice += $groups[$k]['money'];
}
//今日砍价金额
$xiaohsou = pdo_getall('chbl_sun_order',array('uniacid'=>$_W['uniacid']));
$xiaoshouprice = 0;
foreach ($xiaohsou as $k=>$v){
    if($xiaohsou[$k]['pay_time'] == 0) unset($xiaohsou[$k]);
    $xiaohsou[$k]['pay_time'] = date("Y-m-d",$v['pay_time']);
    $yestoday = date("Y-m-d",strtotime("-1 day"));
    if($xiaohsou[$k]['pay_time'] < $yestoday) unset($xiaohsou[$k]);
    $xiaoshouprice += $xiaohsou[$k]['money'];
}

//获取今日红包金额
$jrhb=0;
if($tzinfo){
foreach($tzinfo as $v){
	if($v['hb_random']==1){
		$jrhb+=$v['hb_money'];
	}
	if($v['hb_random']==2){
		$jrhb+=$v['hb_money']*$v['hb_num'];
	}
}
}
$jrtmoney=0;
//今日销售金额
//今日订单销售金额
$sql7=" select  sum(a.money) as ordermoney from (select  id,money,FROM_UNIXTIME(time) as time  from".tablename('chbl_sun_order')." where uniacid={$_W['uniacid']} and state in (2,3,4,5,7)) a  where time like '%{$time}%' ";
$ordermoney=pdo_fetch($sql7);
//商家入驻的钱
$sql8=" select sum(money) as storemoney from".tablename('chbl_sun_storepaylog')." where uniacid={$_W['uniacid']} and  time like '%{$time}%' ";
$storemoney=pdo_fetch($sql8);  


//今日总金额
$jrtmoney=$ordermoney['ordermoney']+$storemoney['storemoney']+$tzmoney['tzmoney']+$pcmoney['pcmoney']+$hymoney['hymoney'];

include $this->template('web/index');