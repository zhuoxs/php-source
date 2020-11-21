<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$uniacid = $_W['uniacid'];
//会员信息
$time=date("Y-m-d");
$time2=date("Y-m-d",strtotime("-1 day"));
$time3=date("Y-m");
//会员总数
$totalhy=pdo_get('mzhk_sun_user', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));

//今日新增会员
$sql=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('mzhk_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jir=count(pdo_fetchall($sql));

//昨日新增
$sql2=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('mzhk_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time2}%' ";
$zuor=count(pdo_fetchall($sql2));

//本月新增
$sql3=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('mzhk_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time3}%' ";
$beny=count(pdo_fetchall($sql3));

//普通订单
//select id,mc,sum(s) from (select a.id id,b.mc mc,sum(b.sl*b.cs) s from a表 a,b表 b where a.1=b.1 and b.mc=XXX group by a.id,a.mc union all select id,,mc,sum(sl*cs+bctl) s from c表 where id=XXXX group by id,mc ) group by id,mc
$day_start = strtotime(date("Y-m-d")." 00:00:00");
$day_end   = strtotime(date("Y-m-d")." 23:59:59");
$yesterday = date("Y-m-d",strtotime("-1 day"));
$yesterday_start = strtotime($yesterday." 00:00:00");
$yesterday_end   = strtotime($yesterday." 23:59:59");
$lastmonth_start = strtotime(date('Y-m-01', strtotime('-1 month'))." 00:00:00");
$lastmonth_end   = strtotime(date('Y-m-t', strtotime('-1 month'))." 23:59:59");
$thismonth = date('Y-m-01', strtotime(date("Y-m-d")));
$thismonth_start = strtotime($thismonth." 00:00:00");
$thismonth_end   = strtotime(date('Y-m-d', strtotime("$thismonth +1 month -1 day"))." 23:59:59");
$thisyear_start = strtotime(date("Y")."-01-01 00:00:00");
$thisyear_end   = strtotime(date("Y")."-12-31 23:59:59");

$where = " where uniacid=".$uniacid." ";

$day_where = $where." and status > 2 and addtime >= ".$day_start." and addtime <= ".$day_end." and not(isrefund = 2) ";
$day_card_where = $where." and status >= 0 and addtime >= ".$day_start." and addtime <= ".$day_end." ";
$sql = "select sum(count) as count,sum(money) as money from (select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_order')." ".$day_where." union all select count(id) as count,sum(money) as money from ".tablename('mzhk_sun_ptgroups')." ".$day_where." union all select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_qgorder')." ".$day_where." union all select count(id) as count,sum(money) as money from ".tablename('mzhk_sun_cardorder')." ".$day_card_where." union all select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_kjorder')." ".$day_where." union all select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_hyorder')." ".$day_card_where." ) as a ";
$day_order = pdo_fetch($sql);

$yesterday_where = $where." and status > 2 and addtime >= ".$yesterday_start." and addtime <= ".$yesterday_end." and not(isrefund = 2) ";
$yesterday_card_where = $where." and status >=0 and addtime >= ".$yesterday_start." and addtime <= ".$yesterday_end."";
$sql = "select sum(count) as count,sum(money) as money from (select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_order')." ".$yesterday_where." union all select count(id) as count,sum(money) as money from ".tablename('mzhk_sun_ptgroups')." ".$yesterday_where." union all select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_qgorder')." ".$yesterday_where." union all select count(id) as count,sum(money) as money from ".tablename('mzhk_sun_cardorder')." ".$yesterday_card_where." union all select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_kjorder')." ".$yesterday_where." union all select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_hyorder')." ".$yesterday_card_where." ) as a ";
$yesterday_order = pdo_fetch($sql);

$lastmonth_where = $where." and status > 2 and addtime >= ".$lastmonth_start." and addtime <= ".$lastmonth_end." and not(isrefund = 2)  ";
$lastmonth_card_where = $where." and status >= 0 and addtime >= ".$lastmonth_start." and addtime <= ".$lastmonth_end." ";
$sql = "select sum(count) as count,sum(money) as money from (select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_order')." ".$lastmonth_where." union all select count(id) as count,sum(money) as money from ".tablename('mzhk_sun_ptgroups')." ".$lastmonth_where." union all select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_qgorder')." ".$lastmonth_where." union all select count(id) as count,sum(money) as money from ".tablename('mzhk_sun_cardorder')." ".$lastmonth_card_where." union all select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_kjorder')." ".$lastmonth_where." union all select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_hyorder')." ".$lastmonth_card_where." ) as a ";
$lastmonth_order = pdo_fetch($sql);

$thismonth_where = $where." and status > 2 and addtime >= ".$thismonth_start." and addtime <= ".$thismonth_end." and not(isrefund = 2)  ";
$thismonth_card_where = $where." and status >= 0 and addtime >= ".$thismonth_start." and addtime <= ".$thismonth_end." ";
$sql = "select sum(count) as count,sum(money) as money from (select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_order')." ".$thismonth_where." union all select count(id) as count,sum(money) as money from ".tablename('mzhk_sun_ptgroups')." ".$thismonth_where." union all select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_qgorder')." ".$thismonth_where." union all select count(id) as count,sum(money) as money from ".tablename('mzhk_sun_cardorder')." ".$thismonth_card_where." union all select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_kjorder')." ".$thismonth_where." union all select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_hyorder')." ".$thismonth_card_where." ) as a ";
$thismonth_order = pdo_fetch($sql);

$thisyear_where = $where." and status > 2 and addtime >= ".$thisyear_start." and addtime <= ".$thisyear_end." and not(isrefund = 2)  ";
$thisyear_card_where = $where." and status >= 0 and addtime >= ".$thisyear_start." and addtime <= ".$thisyear_end." ";
$sql = "select sum(count) as count,sum(money) as money from (select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_order')." ".$thisyear_where." union all select count(id) as count,sum(money) as money from ".tablename('mzhk_sun_ptgroups')." ".$thisyear_where." union all select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_qgorder')." ".$thisyear_where." union all select count(id) as count,sum(money) as money from ".tablename('mzhk_sun_cardorder')." ".$thisyear_card_where." union all select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_kjorder')." ".$thisyear_where." union all select count(oid) as count,sum(money) as money from ".tablename('mzhk_sun_hyorder')." ".$thisyear_card_where." ) as a ";
$thisyear_order = pdo_fetch($sql);


//
//资讯数量



include $this->template('web/index');