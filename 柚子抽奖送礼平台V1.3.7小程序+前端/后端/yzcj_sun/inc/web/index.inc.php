<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

//会员信息
$time=date("Y-m-d");
$time2=date("Y-m-d",strtotime("-1 day"));
$time3=date("Y-m");

//会员总数
$totalhy=pdo_get('yzcj_sun_user', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));

//今日新增会员
$sql=" select a.* from (select  id,time  from".tablename('yzcj_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jir=count(pdo_fetchall($sql));

//昨日新增
$sql2=" select a.* from (select  id,time  from".tablename('yzcj_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time2}%' ";
$zuor=count(pdo_fetchall($sql2));

//本月新增
$sql3=" select a.* from (select  id,time  from".tablename('yzcj_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time3}%' ";
$beny=count(pdo_fetchall($sql3));

//商品一览
//商品总数
$goodstotal=pdo_get('yzcj_sun_goods', array('uniacid'=>$_W['uniacid']),array('count(gid) as count'));

// 新增商品
$sql4=" select a.* from (select gid,selftime as time  from".tablename('yzcj_sun_goods')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jrgoods=count(pdo_fetchall($sql4));
// var_dump($sql4);
//总共订单
$totalorder=pdo_get('yzcj_sun_order', array('uniacid'=>$_W['uniacid']), array('count(oid) as count'));

//代发货订单
$dfhorder=pdo_get('yzcj_sun_order', array('uniacid'=>$_W['uniacid'],'status'=>2), array('count(oid) as count'));

//文章一览
//文章总数
$zxtotal=pdo_get('yzcj_sun_circle', array('uniacid'=>$_W['uniacid']),array('count(id) as count'));

// 新增文章
$sql5=" select a.* from (select id,time as time  from".tablename('yzcj_sun_circle')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jrzx=count(pdo_fetchall($sql5));
// var_dump($sql4);
//评论
$totalzx=pdo_get('yzcj_sun_content', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));
// 新增文章
$sql6=" select a.* from (select id,time as time  from".tablename('yzcj_sun_content')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$dfhzx=count(pdo_fetchall($sql6));

//礼物总数
$giftstotal2=pdo_get('yzcj_sun_gifts', array('uniacid'=>$_W['uniacid'],'status'=>2),array('count(id) as count'));
$giftstotal1=pdo_get('yzcj_sun_gifts', array('uniacid'=>$_W['uniacid'],'status'=>1),array('count(id) as count'));

// 新增礼物
$sql6=" select a.* from (select id,time  from".tablename('yzcj_sun_gifts')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
$jrgifts=count(pdo_fetchall($sql6));

$sponsor=pdo_getall('yzcj_sun_sponsorship',array('uniacid'=>$_W['uniacid'],'status'=>2));
foreach ($sponsor as $key => $value) {
	$nowtime=time();
	$overtime=strtotime($value['endtime']);
	if($nowtime>$overtime){
		$data['status']=4;
		$res=pdo_update('yzcj_sun_sponsorship',$data,array('sid'=>$value['sid'],'uniacid'=>$_W['uniacid']));
	}
}

include $this->template('web/index');