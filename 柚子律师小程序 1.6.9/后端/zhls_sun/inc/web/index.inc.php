<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();


$day_start = strtotime(date("Y-m-d")." 00:00:00");
$day_end = strtotime(date("Y-m-d")." 23:59:59");

$yesterday = date("Y-m-d",strtotime("-1 day"));
$yesterday_start = strtotime($yesterday." 00:00:00");
$yesterday_end   = strtotime($yesterday." 23:59:59");

$thismonth = date('Y-m-01', strtotime(date("Y-m-d")));
$thismonth_start = strtotime($thismonth." 00:00:00");
$thismonth_end   = strtotime(date('Y-m-d', strtotime("$thismonth +1 month -1 day"))." 23:59:59");

/*会员信息*/
//今日新增
$sql1="select count(id) as num from " .tablename('zhls_sun_user'). " where uniacid=".$_W['uniacid']." and rtime>=".$day_start." and rtime<=".$day_end." ";
$jir = pdo_fetch($sql1);

//昨日新增
$sql2="select count(id) as num from " .tablename('zhls_sun_user'). " where uniacid=".$_W['uniacid']." and rtime>=".$yesterday_start." and rtime<=".$yesterday_end." ";
$zuor = pdo_fetch($sql2);

//本月新增
$sql3="select count(id) as num from " .tablename('zhls_sun_user'). " where uniacid=".$_W['uniacid']." and rtime>=".$thismonth_start." and rtime<=".$thismonth_end." ";
$beny = pdo_fetch($sql3);

//会员总数
$sql="select count(id) as num from " .tablename('zhls_sun_user'). " where uniacid=".$_W['uniacid']." ";
$totalhy = pdo_fetch($sql);




/*商品一览*/
//在线预约总数
$goodstotal=pdo_get('zhls_sun_appointment', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));
//在线预约未查看
$jrgoods=pdo_get('zhls_sun_appointment', array('uniacid'=>$_W['uniacid'],'status'=>0), array('count(id) as count'));

//付费咨询总数
$totalorder=pdo_get('zhls_sun_fproblem', array('uniacid'=>$_W['uniacid']), array('count(fid) as count'));
//付费咨询待回复数
$dfhorder=pdo_get('zhls_sun_fproblem', array('uniacid'=>$_W['uniacid'],'is_answer'=>0), array('count(fid) as count'));


/*数据概况*/
// 今日预约
$visitor = pdo_getall('zhls_sun_appointment',['uniacid'=>$_W['uniacid']]);
$visis = [];
foreach ($visitor as $k=>$v){
    if(date('Y-m-d',$v['subtime'])==date('Y-m-d')){
        $visis[] = $v;
    }
}
$visi = count($visis);
//今日总金额
$sql4="select sum(amount) as money from " .tablename('zhls_sun_fproblem'). " where uniacid=".$_W['uniacid']." and time>=".$day_start." and time<=".$day_end." ";
$jrtmoney = pdo_fetch($sql4);

include $this->template('web/index');