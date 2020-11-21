<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

//会员信息
$time=date("Y-m-d");
$time2=date("Y-m-d",strtotime("-1 day"));
$time3=date("Y-m");
//会员总数
$totalhy=pdo_get('ymmf_sun_user', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));
//今日新增会员
$sql=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('ymmf_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jir=count(pdo_fetchall($sql));
//昨日新增
$sql2=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('ymmf_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time2}%' ";
$zuor=count(pdo_fetchall($sql2));
//本月新增
$sql3=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('ymmf_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time3}%' ";
$beny=count(pdo_fetchall($sql3));
//商品一览
//商品总数
$goodstotal=pdo_get('ymmf_sun_goods', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));
//新增商品
$sql4=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('ymmf_sun_goods')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jrgoods=count(pdo_fetchall($sql4));
//总共订单
$totalorder=pdo_get('ymmf_sun_order', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));

//代服务订单
$dfhorder=pdo_get('ymmf_sun_order', array('uniacid'=>$_W['uniacid'],'isdefault'=>0), array('count(id) as count'));

//帖子数量
$tztotal=pdo_get('ymmf_sun_information', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));
//商户数量
$shtotal=pdo_get('ymmf_sun_store', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));
//拼车数量
$pctotal=pdo_get('ymmf_sun_car', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));
//黄页数量
$hytotal=pdo_get('ymmf_sun_yellowstore', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));
//资讯数量
$zxtotal=pdo_get('ymmf_sun_zx', array('uniacid'=>$_W['uniacid'],'state'=>2), array('count(id) as count'));

//数据概况
//今日新增帖子
$sql5=" select a.* from (select  id,hb_money,hb_num,hb_type,hb_random,FROM_UNIXTIME(sh_time) as time  from".tablename('ymmf_sun_information')." where uniacid={$_W['uniacid']} and state=2) a where time like '%{$time}%' ";
$tzinfo=pdo_fetchall($sql5);
$jrtz=count($tzinfo);
//今日新增商户
$sql6=" select a.* from (select  id,FROM_UNIXTIME(sh_time) as time  from".tablename('ymmf_sun_store')." where uniacid={$_W['uniacid']} and state=2) a where time like '%{$time}%' ";
$jrsh=count(pdo_fetchall($sql6));
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
$sql7=" select  sum(a.money) as ordermoney from (select  id,money,FROM_UNIXTIME(time) as time  from".tablename('ymmf_sun_order')." where uniacid={$_W['uniacid']} and state in (2,3,4,5,7)) a  where time like '%{$time}%' ";
$ordermoney=pdo_fetch($sql7);
//商家入驻的钱
$sql8=" select sum(money) as storemoney from".tablename('ymmf_sun_storepaylog')." where uniacid={$_W['uniacid']} and  time like '%{$time}%' ";
$storemoney=pdo_fetch($sql8);  
//帖子入驻加置顶
$sql9=" select sum(money) as tzmoney from".tablename('ymmf_sun_tzpaylog')." where uniacid={$_W['uniacid']} and  time like '%{$time}%' ";
$tzmoney=pdo_fetch($sql9); 
//拼车发布的钱
$sql10=" select sum(money) as pcmoney from".tablename('ymmf_sun_carpaylog')." where uniacid={$_W['uniacid']} and  time like '%{$time}%' ";
$pcmoney=pdo_fetch($sql10); 
//114入驻的钱
$sql11=" select sum(money) as hymoney from".tablename('ymmf_sun_yellowpaylog')." where uniacid={$_W['uniacid']} and  time like '%{$time}%' ";
$hymoney=pdo_fetch($sql11); 
// 今日预约
$visitor = pdo_getall('ymmf_sun_visitor',array('uniacid'=>$_W['uniacid'],'time'=>date('Y-m-d',time())));
$visi = count($visitor);
// 今日完成订单
$orderlost = pdo_getall('ymmf_sun_orderlost',array('uniacid'=>$_W['uniacid'],'time'=>date('Y-m-d',time())));
$lost = count($orderlost);
//今日总金额
$jrtmoney=$ordermoney['ordermoney']+$storemoney['storemoney']+$tzmoney['tzmoney']+$pcmoney['pcmoney']+$hymoney['hymoney'];

$order = pdo_getall('ymmf_sun_order',array('uniacid'=>$_W['uniacid']));
$todaymoney = 0;
foreach ($order as $k=>$v){
    if(date('Y-m-d')==date('Y-m-d',strtotime($v['addtime']))){
        $todaymoney += $v['money'];
    }
}
$maidan = pdo_getall('ymmf_sun_maidan',array('uniacid'=>$_W['uniacid']));
foreach ($maidan as $k=>$v){
    if(date('Y-m-d')==date('Y-m-d',$v['addtime'])){
        $todaymoney += $v['price'];
    }

}
include $this->template('web/index');