<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

//会员信息
$time=date("Y-m-d");
$time2=date("Y-m-d",strtotime("-1 day"));
$time3=date("Y-m");

//商品一览
//商品总数
$goodstotal=pdo_get('mzhk_sun_plugin_lottery_goods', array('uniacid'=>$_W['uniacid']),array('count(gid) as count'));

// 新增商品
$sql4=" select a.* from (select gid,selftime as time  from".tablename('mzhk_sun_plugin_lottery_goods')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jrgoods=count(pdo_fetchall($sql4));
// var_dump($sql4);
//总共订单
$totalorder=pdo_get('mzhk_sun_plugin_lottery_order', array('uniacid'=>$_W['uniacid']), array('count(oid) as count'));

//代发货订单
$dfhorder=pdo_get('mzhk_sun_plugin_lottery_order', array('uniacid'=>$_W['uniacid'],'status'=>2), array('count(oid) as count'));

//礼物总数
$giftstotal2=pdo_get('mzhk_sun_plugin_lottery_gifts', array('uniacid'=>$_W['uniacid'],'status'=>2),array('count(id) as count'));
$giftstotal1=pdo_get('mzhk_sun_plugin_lottery_gifts', array('uniacid'=>$_W['uniacid'],'status'=>1),array('count(id) as count'));

// 新增礼物
$sql6=" select a.* from (select id,time  from".tablename('mzhk_sun_plugin_lottery_gifts')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jrgifts=count(pdo_fetchall($sql6));

$sponsor=pdo_getall('mzhk_sun_plugin_lottery_sponsorship',array('uniacid'=>$_W['uniacid'],'status'=>2));
foreach ($sponsor as $key => $value) {
	$nowtime=time();
	$overtime=strtotime($value['endtime']);
	if($nowtime>$overtime){
		$data['status']=4;
		$res=pdo_update('mzhk_sun_plugin_lottery_sponsorship',$data,array('sid'=>$value['sid'],'uniacid'=>$_W['uniacid']));
	}
}

include $this->template('web/index');