<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu2();
if($_GPC['cityname']){

  setcookie('cityname',$_GPC['cityname']);
  //$cityname=$_COOKIE['cityname'];
  $_COOKIE['cityname']=$_GPC['cityname'];
  setcookie('account_id',$_GPC['account_id']);
  //$_COOKIE['account_id']=$_GPC['account_id'];
}
$time=date("Y-m-d");
$time2=date("Y-m-d",strtotime("-1 day"));
$time3=date("Y-m");
$time4=strtotime(date("Y-m-d",strtotime("-6 day")));
//销售盘点
//今日订单统计
$sql1=" select  count(*) as count from (select  a.id,a.money,FROM_UNIXTIME(a.time) as time  from".tablename('zhls_sun_order'). " a"  . " left join " . tablename("zhls_sun_store") . " b on a.store_id=b.id where a.uniacid={$_W['uniacid']} and b.cityname='{$_COOKIE['cityname']}' ) a  where time like '%{$time}%' ";
$ordercount=pdo_fetch($sql1);
//本月总额
//本月订单销售金额
$sql5=" select  sum(a.money) as ordermoney from (select  a.id,a.money,FROM_UNIXTIME(a.time) as time  from".tablename('zhls_sun_order'). " a"  . " left join " . tablename("zhls_sun_store") . " b on a.store_id=b.id  where a.uniacid={$_W['uniacid']} and a.state in (2,3,4,5,7) and b.cityname='{$_COOKIE['cityname']}') a  where time like '%{$time3}%' ";
$ordermoney=pdo_fetch($sql5);
//本月商家入驻的钱
$sql6="select sum(a.money) as storemoney from".tablename('zhls_sun_storepaylog'). " a"  . " left join " . tablename("zhls_sun_store") . " b on a.store_id=b.id where a.uniacid={$_W['uniacid']} and b.cityname='{$_COOKIE['cityname']}' and  a.time like '%{$time3}%' ";
$storemoney=pdo_fetch($sql6);  
//本月帖子入驻加置顶
$sql7=" select sum(a.money) as tzmoney from".tablename('zhls_sun_tzpaylog'). " a"  . " left join " . tablename("zhls_sun_information") . " b on a.tz_id=b.id  where a.uniacid={$_W['uniacid']} and b.cityname='{$_COOKIE['cityname']}' and  a.time like '%{$time3}%'  ";
$tzmoney=pdo_fetch($sql7); 
//本月拼车发布的钱
$sql8=" select sum(a.money) as pcmoney from".tablename('zhls_sun_carpaylog'). " a"  . " left join " . tablename("zhls_sun_car") . " b on a.car_id=b.id  where a.uniacid={$_W['uniacid']} and b.cityname='{$_COOKIE['cityname']}' and  a.time like '%{$time3}%' ";
$pcmoney=pdo_fetch($sql8); 
//本月114入驻的钱
$sql9=" select sum(a.money) as hymoney from".tablename('zhls_sun_yellowpaylog'). " a"  . " left join " . tablename("zhls_sun_yellowstore") . " b on a.hy_id=b.id  where a.uniacid={$_W['uniacid']} and b.cityname='{$_COOKIE['cityname']}' and  a.time like '%{$time3}%'";
$hymoney=pdo_fetch($sql9); 

//本月今日总金额
$bytmoney=$ordermoney['ordermoney']+$storemoney['storemoney']+$tzmoney['tzmoney']+$pcmoney['pcmoney']+$hymoney['hymoney'];

//本月可获得佣金
$yjtype=pdo_get('zhls_sun_yjset',array('uniacid'=>$_W['uniacid']));
$kdyj=0;
if($yjtype['type']==1){
	$kdyj=$bytmoney*$yjtype['typer']/100;
}
if($yjtype['type']==2){
	$kdyj=(($ordermoney['ordermoney']+$storemoney['storemoney'])*$yjtype['sjper']+$tzmoney['tzmoney']*$yjtype['tzper']+$pcmoney['pcmoney']*$yjtype['pcper']+$hymoney['hymoney']*$yjtype['pcper'])/100;
}
$kdyj=number_format($kdyj, 2);
//商品一览
//商品总数
 $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("zhls_sun_goods") . " a"  . " left join " . tablename("zhls_sun_store") . " b on a.store_id=b.id  WHERE  a.uniacid={$_W['uniacid']}  and b.cityname='{$_COOKIE['cityname']}' and a.state=2" );
//新增商品
$sql11=" select c.* from (select  a.id,FROM_UNIXTIME(a.time) as time  from".tablename('zhls_sun_goods') . " a"  . " left join " . tablename("zhls_sun_store") . " b on a.store_id=b.id where a.uniacid={$_W['uniacid']} and b.cityname='{$_COOKIE['cityname']}') c where time like '%{$time}%' ";
$jrgoods=count(pdo_fetchall($sql11));



//待审核帖子数量
$tztotal=pdo_get('zhls_sun_information', array('uniacid'=>$_W['uniacid'],'state'=>1,'cityname'=>$_COOKIE['cityname']), array('count(id) as count'));
//待审核商户数量
//$sptotal=pdo_get('zhls_sun_goods', array('uniacid'=>$_W['uniacid'],'state'=>1,'cityname'=>$_COOKIE['cityname']), array('count(id) as count'));
//待审核商品数量
$sptotal=pdo_fetchcolumn("select count(*) as wname from " . tablename("zhls_sun_goods") . " a"  . " left join " . tablename("zhls_sun_store") . " b on a.store_id=b.id  WHERE  a.uniacid={$_W['uniacid']}  and b.cityname='{$_COOKIE['cityname']}' and a.state=1" );

//待审核拼车数量
$pctotal=pdo_get('zhls_sun_car', array('uniacid'=>$_W['uniacid'],'state'=>1,'cityname'=>$_COOKIE['cityname']), array('count(id) as count'));
//待审核黄页数量
$hytotal=pdo_get('zhls_sun_yellowstore', array('uniacid'=>$_W['uniacid'],'state'=>1,'cityname'=>$_COOKIE['cityname']), array('count(id) as count'));
//待审核资讯数量
$zxtotal=pdo_get('zhls_sun_zx', array('uniacid'=>$_W['uniacid'],'state'=>1,'cityname'=>$_COOKIE['cityname']), array('count(id) as count'));

$jrtmoney=0.00;
//今日销售金额
//今日订单销售金额
$sql13=" select  sum(a.money) as ordermoney from (select  a.id,a.money,FROM_UNIXTIME(a.time) as time  from".tablename('zhls_sun_order'). " a"  . " left join " . tablename("zhls_sun_store") . " b on a.store_id=b.id  where a.uniacid={$_W['uniacid']} and a.state in (2,3,4,5,7) and b.cityname='{$_COOKIE['cityname']}') a  where time like '%{$time}%' ";
$jrordermoney=pdo_fetch($sql13);
//商家入驻的钱
$sql14=" select sum(a.money) as storemoney from".tablename('zhls_sun_storepaylog'). " a"  . " left join " . tablename("zhls_sun_store") . " b on a.store_id=b.id where a.uniacid={$_W['uniacid']} and b.cityname='{$_COOKIE['cityname']}' and  a.time like '%{$time}%' ";
$jrstoremoney=pdo_fetch($sql14);  
//帖子入驻加置顶
$sql15=" select sum(a.money) as tzmoney from".tablename('zhls_sun_tzpaylog'). " a"  . " left join " . tablename("zhls_sun_information") . " b on a.tz_id=b.id  where a.uniacid={$_W['uniacid']} and b.cityname='{$_COOKIE['cityname']}' and  a.time like '%{$time}%' ";
$jrtzmoney=pdo_fetch($sql15); 
//拼车发布的钱
$sql16=" select sum(a.money) as pcmoney from".tablename('zhls_sun_carpaylog'). " a"  . " left join " . tablename("zhls_sun_car") . " b on a.car_id=b.id  where a.uniacid={$_W['uniacid']} and b.cityname='{$_COOKIE['cityname']}' and  a.time like '%{$time}%' ";
$jrpcmoney=pdo_fetch($sql16); 
//114入驻的钱
$sql17=" select sum(a.money) as hymoney from".tablename('zhls_sun_yellowpaylog'). " a"  . " left join " . tablename("zhls_sun_yellowstore") . " b on a.hy_id=b.id  where a.uniacid={$_W['uniacid']} and b.cityname='{$_COOKIE['cityname']}' and  a.time like '%{$time}%' ";
$jrhymoney=pdo_fetch($sql17);
//今日总金额
$jrtmoney=$jrordermoney['ordermoney']+$jrstoremoney['storemoney']+$jrtzmoney['tzmoney']+$jrpcmoney['pcmoney']+$jrhymoney['hymoney'];

$jrtmoney=number_format($jrtmoney, 2);

//昨日销售总额
//昨日订单销售金额
$sql18=" select  sum(a.money) as ordermoney from (select  a.id,a.money,FROM_UNIXTIME(a.time) as time  from".tablename('zhls_sun_order'). " a"  . " left join " . tablename("zhls_sun_store") . " b on a.store_id=b.id  where a.uniacid={$_W['uniacid']} and a.state in (2,3,4,5,7) and b.cityname='{$_COOKIE['cityname']}') a  where time like '%{$time2}%' ";
$zrordermoney=pdo_fetch($sql18);
//昨日商家入驻的钱
$sql19=" select sum(a.money) as storemoney from".tablename('zhls_sun_storepaylog'). " a"  . " left join " . tablename("zhls_sun_store") . " b on a.store_id=b.id where a.uniacid={$_W['uniacid']} and b.cityname='{$_COOKIE['cityname']}' and  a.time like '%{$time2}%' ";
$zrstoremoney=pdo_fetch($sql19);  
//昨日帖子入驻加置顶
$sql20=" select sum(a.money) as tzmoney from".tablename('zhls_sun_tzpaylog'). " a"  . " left join " . tablename("zhls_sun_information") . " b on a.tz_id=b.id  where a.uniacid={$_W['uniacid']} and b.cityname='{$_COOKIE['cityname']}' and  a.time like '%{$time2}%' ";
$zrtzmoney=pdo_fetch($sql20); 
//昨日拼车发布的钱
$sql21=" select sum(a.money) as pcmoney from".tablename('zhls_sun_carpaylog'). " a"  . " left join " . tablename("zhls_sun_car") . " b on a.car_id=b.id  where a.uniacid={$_W['uniacid']} and b.cityname='{$_COOKIE['cityname']}' and  a.time like '%{$time2}%' ";
$zrpcmoney=pdo_fetch($sql21); 
//昨日114入驻的钱
$sql22=" select sum(a.money) as hymoney from".tablename('zhls_sun_yellowpaylog'). " a"  . " left join " . tablename("zhls_sun_yellowstore") . " b on a.hy_id=b.id  where a.uniacid={$_W['uniacid']} and b.cityname='{$_COOKIE['cityname']}' and  a.time like '%{$time2}%' ";
$zrhymoney=pdo_fetch($sql22);
//昨日今日总金额
$zrtmoney=$zrordermoney['ordermoney']+$zrstoremoney['storemoney']+$zrtzmoney['tzmoney']+$zrpcmoney['pcmoney']+$zrhymoney['hymoney'];

//本周销售总额
//本周订单销售金额
$sql23=" select  sum(a.money) as ordermoney,a.time from ".tablename('zhls_sun_order'). " a"  . " left join " . tablename("zhls_sun_store") . " b on a.store_id=b.id  where a.uniacid={$_W['uniacid']} and a.state in (2,3,4,5,7) and b.cityname='{$_COOKIE['cityname']}' and a.time >$time4 ";
$bzordermoney=pdo_fetch($sql23);
//本周商家入驻的钱
$sql24=" select  sum(a.money) as storemoney,a.sjc from (select a.money, UNIX_TIMESTAMP(a.time) as sjc from".tablename('zhls_sun_storepaylog'). " a"  . " left join " . tablename("zhls_sun_store") . " b on a.store_id=b.id where a.uniacid={$_W['uniacid']} and b.cityname='{$_COOKIE['cityname']}') a where a.sjc > $time4 ";
$bzstoremoney=pdo_fetch($sql24);  

//本周帖子入驻加置顶
$sql25=" select  sum(a.money) as tzmoney,a.sjc from (select a.money,UNIX_TIMESTAMP(a.time) as sjc from".tablename('zhls_sun_tzpaylog'). " a"  . " left join " . tablename("zhls_sun_information") . " b on a.tz_id=b.id  where a.uniacid={$_W['uniacid']} and b.cityname='{$_COOKIE['cityname']}' )a where a.sjc > $time4 ";
$bztzmoney=pdo_fetch($sql25); 

//本周拼车发布的钱
$sql26=" select  sum(a.money) as pcmoney,a.sjc from (select a.money,UNIX_TIMESTAMP(a.time) as sjc from".tablename('zhls_sun_carpaylog'). " a"  . " left join " . tablename("zhls_sun_car") . " b on a.car_id=b.id  where a.uniacid={$_W['uniacid']} and b.cityname='{$_COOKIE['cityname']}') a where a.sjc > $time4 ";
$bzpcmoney=pdo_fetch($sql26); 

//本周114入驻的钱
$sql27=" select  sum(a.money) as hymoney,a.sjc from (select a.money,UNIX_TIMESTAMP(a.time) as sjc from".tablename('zhls_sun_yellowpaylog'). " a"  . " left join " . tablename("zhls_sun_yellowstore") . " b on a.hy_id=b.id  where a.uniacid={$_W['uniacid']} and b.cityname='{$_COOKIE['cityname']}' ) a where a.sjc > $time4 ";
$bzhymoney=pdo_fetch($sql27); 
//本周今日总金额
$bztmoney=$bzordermoney['ordermoney']+$bzstoremoney['storemoney']+$bztzmoney['tzmoney']+$bzpcmoney['pcmoney']+$bzhymoney['hymoney'];


include $this->template('web/inindex');