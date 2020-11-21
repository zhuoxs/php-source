<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();


//会员信息
$time=date("Y-m-d");
$time2=date("Y-m-d",strtotime("-1 day"));
$time3=date("Y-m");
$time_jr=strtotime($time);
$month=date('Y-m');
$time_month=strtotime($month);
$year=date('Y-1-1');
$time_year=strtotime($year);

//会员总数
$totalhy=pdo_get('yzqzk_sun_user', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));
//今日新增会员
$sql=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('yzqzk_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jir=count(pdo_fetchall($sql));
//昨日新增
$sql2=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('yzqzk_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time2}%' ";
$zuor=count(pdo_fetchall($sql2));
//本月新增
$sql3=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('yzqzk_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time3}%' ";
$beny=count(pdo_fetchall($sql3));
//商品一览
//商品总数
$goodstotal=pdo_get('yzqzk_sun_goods', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));
//新增商品
$sql4=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('yzqzk_sun_goods')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jrgoods=count(pdo_fetchall($sql4));

//今日新增活动
$sql5=" select a.* from (select  id,FROM_UNIXTIME(add_time) as time  from".tablename('yzqzk_sun_activity')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jractivity=count(pdo_fetchall($sql5));

//总活动
$totaloactivity=pdo_get('yzqzk_sun_activity', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));



//总共订单
$totalorder=pdo_get('yzqzk_sun_order', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));
//代发货订单
$dfhorder=pdo_get('yzqzk_sun_order', array('uniacid'=>$_W['uniacid'],'order_status'=>1), array('count(id) as count'));

//今日销售总额
$sql="SELECT sum(order_amount) FROM ".tablename('yzqzk_sun_order')." where uniacid={$_W['uniacid']} and pay_status=1 and pay_time>=$time_jr";
$total_sale_money= pdo_fetchcolumn($sql);
$total_sale_money=$total_sale_money?$total_sale_money:0;

//本月销售总额
$sql="SELECT sum(order_amount) FROM ".tablename('yzqzk_sun_order')." where uniacid={$_W['uniacid']} and pay_status=1 and pay_time>=$time_month";
$total_month_money= pdo_fetchcolumn($sql);
$total_month_money=$total_month_money?$total_month_money:0;

//本年销售总额
$sql="SELECT sum(order_amount) FROM ".tablename('yzqzk_sun_order')." where uniacid={$_W['uniacid']} and pay_status=1 and pay_time>=$time_year";
$total_year_money= pdo_fetchcolumn($sql);
$total_year_money=$total_year_money?$total_year_money:0;

//亲子卡充值金额
$sql="SELECT sum(order_amount) FROM ".tablename('yzqzk_sun_order')." where uniacid={$_W['uniacid']} and pay_status=1 and pay_time>=$time_jr and order_lid=1";
$total_qzkcz_money= pdo_fetchcolumn($sql);
$total_qzkcz_money=$total_qzkcz_money?$total_qzkcz_money:0;
//今日活动金额
$sql="SELECT sum(order_amount) FROM ".tablename('yzqzk_sun_order')." where uniacid={$_W['uniacid']} and pay_status=1 and pay_time>=$time_jr and order_lid=3";
$total_activity_money= pdo_fetchcolumn($sql);
$total_activity_money=$total_activity_money?$total_activity_money:0;

//今日预约金额
$sql="SELECT sum(order_amount) FROM ".tablename('yzqzk_sun_order')." where uniacid={$_W['uniacid']} and pay_status=1 and pay_time>=$time_jr and order_lid=2";
$total_book_money= pdo_fetchcolumn($sql);
$total_book_money=$total_book_money?$total_book_money:0;

//今日拼团金额
$sql="SELECT sum(order_amount) FROM ".tablename('yzqzk_sun_order')." where uniacid={$_W['uniacid']} and pay_status=1 and pay_time>=$time_jr and order_lid=4";
$total_groups_money= pdo_fetchcolumn($sql);
$total_groups_money=$total_groups_money?$total_groups_money:0;

//今日砍价金额
$sql="SELECT sum(order_amount) FROM ".tablename('yzqzk_sun_order')." where uniacid={$_W['uniacid']} and pay_status=1 and pay_time>=$time_jr and order_lid=5";
$total_bargain_money= pdo_fetchcolumn($sql);
$total_bargain_money=$total_bargain_money?$total_bargain_money:0;

//今日到店买单
$sql="SELECT sum(order_amount) FROM ".tablename('yzqzk_sun_order')." where uniacid={$_W['uniacid']} and pay_status=1 and pay_time>=$time_jr and order_lid=8";
$total_ddmd_money= pdo_fetchcolumn($sql);
$total_ddmd_money=$total_ddmd_money?$total_ddmd_money:0;

//今日普通订单金额
$sql="SELECT sum(order_amount) FROM ".tablename('yzqzk_sun_order')." where uniacid={$_W['uniacid']} and pay_status=1 and pay_time>=$time_jr and order_lid in(1,3,6,7)";
$total_common_money= pdo_fetchcolumn($sql);
$total_common_money=$total_common_money?$total_common_money:0;

/*
//帖子数量
$tztotal=pdo_get('yzqzk_sun_information', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));
//商户数量
$shtotal=pdo_get('yzqzk_sun_store', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));
//拼车数量
$pctotal=pdo_get('yzqzk_sun_car', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));
//黄页数量
$hytotal=pdo_get('yzqzk_sun_yellowstore', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));
//资讯数量
$zxtotal=pdo_get('yzqzk_sun_zx', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));

//数据概况
//今日新增帖子
$sql5=" select a.* from (select  id,hb_money,hb_num,hb_type,hb_random,FROM_UNIXTIME(sh_time) as time  from".tablename('yzqzk_sun_information')." where uniacid={$_W['uniacid']} and state=2) a where time like '%{$time}%' ";
$tzinfo=pdo_fetchall($sql5);
$jrtz=count($tzinfo);
//今日新增头条
$sqltt = ' SELECT * FROM ' . tablename('yzqzk_sun_zx') . ' WHERE' . ' uniacid=' . $_W['uniacid'] . ' AND' . " time like '%{$time}%' ";
$ttinfo=pdo_fetchall($sqltt);
$jrtt=count($ttinfo);

//今日新增商户
$sh = pdo_getall('yzqzk_sun_store_active',array('uniacid'=>$_W['uniacid']));
foreach ($sh as $k=>$v){
    $sh[$k]['rz_time'] = date("Y-m-d",$v['rz_time']);
    $yestoday = date("Y-m-d",strtotime("-1 day"));
    if($sh[$k]['rz_time'] < $yestoday) unset($sh[$k]);
}
$jrsh=count($sh);
//今日砍价金额
$kanjia = pdo_getall('yzqzk_sun_order',array('uniacid'=>$_W['uniacid'],'out_trade_no'=>1));

foreach ($kanjia as $k=>$v){
    if($kanjia[$k]['pay_time'] == 0) unset($kanjia[$k]);
    $kanjia[$k]['pay_time'] = date("Y-m-d",$v['pay_time']);
    $yestoday = date("Y-m-d",strtotime("-1 day"));
    if($kanjia[$k]['pay_time'] < $yestoday) unset($kanjia[$k]);
    $kanjiaprice += $kanjia[$k]['good_money'];
}
//今日砍价金额
$xiaohsou = pdo_getall('yzqzk_sun_order',array('uniacid'=>$_W['uniacid']));

foreach ($xiaohsou as $k=>$v){
    if($xiaohsou[$k]['pay_time'] == 0) unset($xiaohsou[$k]);
    $xiaohsou[$k]['pay_time'] = date("Y-m-d",$v['pay_time']);
    $yestoday = date("Y-m-d",strtotime("-1 day"));
    if($xiaohsou[$k]['pay_time'] < $yestoday) unset($xiaohsou[$k]);
    $xiaoshouprice += $xiaohsou[$k]['good_money'];
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
$sql7=" select  sum(a.money) as ordermoney from (select  id,money,FROM_UNIXTIME(time) as time  from".tablename('yzqzk_sun_order')." where uniacid={$_W['uniacid']} and state in (2,3,4,5,7)) a  where time like '%{$time}%' ";
$ordermoney=pdo_fetch($sql7);
//商家入驻的钱
$sql8=" select sum(money) as storemoney from".tablename('yzqzk_sun_storepaylog')." where uniacid={$_W['uniacid']} and  time like '%{$time}%' ";
$storemoney=pdo_fetch($sql8);  
//帖子入驻加置顶
$sql9=" select sum(money) as tzmoney from".tablename('yzqzk_sun_tzpaylog')." where uniacid={$_W['uniacid']} and  time like '%{$time}%' ";
$tzmoney=pdo_fetch($sql9); 
//拼车发布的钱
$sql10=" select sum(money) as pcmoney from".tablename('yzqzk_sun_carpaylog')." where uniacid={$_W['uniacid']} and  time like '%{$time}%' ";
$pcmoney=pdo_fetch($sql10); 
//114入驻的钱
$sql11=" select sum(money) as hymoney from".tablename('yzqzk_sun_yellowpaylog')." where uniacid={$_W['uniacid']} and  time like '%{$time}%' ";
$hymoney=pdo_fetch($sql11); 

//今日总金额
$jrtmoney=$ordermoney['ordermoney']+$storemoney['storemoney']+$tzmoney['tzmoney']+$pcmoney['pcmoney']+$hymoney['hymoney'];*/

include $this->template('web/index');