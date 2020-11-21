<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();


$day = strtotime(date('Y-m-d',time()));//获取今天凌晨的时间戳
$time2=strtotime(date("Y-m-d",strtotime("-1 day")));//获取昨天凌晨的时间戳
$time3=strtotime(date("Y-m"));//当月
/************************************************会员*****************************************************/
//会员总数
$alluser= pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzzc_sun_user')."where uniacid = ".$_W['uniacid']);
//今日新增会员
$todayuser=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzzc_sun_user')."where time >".$day." and uniacid = ".$_W['uniacid']);
//昨日新增
$yesterdayuser=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzzc_sun_user')."where time between ".$time2 ." and ".$day ." and uniacid = ".$_W['uniacid']);
//本月新增
$monthuser=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzzc_sun_user')."where time >".$time3 ." and uniacid = ".$_W['uniacid']);

/************************************************车辆*****************************************************/

//已租车辆车辆
$yzcar=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzzc_sun_goods')."where status = 2 and uniacid = ".$_W['uniacid'] );
//未租车辆
$wzcar=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzzc_sun_goods')."where status = 1 and uniacid = ".$_W['uniacid']);
//全部订单数
$allorder=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzzc_sun_order')."where uniacid = ".$_W['uniacid']);
//已付款订单数
$fkorder=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzzc_sun_order')."where (status = 2 or status =3 or status = 0) and uniacid = ".$_W['uniacid']);

/************************************************其他数据*****************************************************/
//门店数
$shop=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzzc_sun_branch')."where uniacid = ".$_W['uniacid']);
//今日订单数
$todayorder=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzzc_sun_order')."where createtime >".$day. " and uniacid = ".$_W['uniacid']);
//今日订单总额
$tmoney=pdo_fetch("SELECT SUM(prepay_money) as money FROM ".tablename('yzzc_sun_order')."where createtime >".$day." and uniacid = ".$_W['uniacid']." and (status = 2 or status =3 or status = 0)")['money'];
$todaymoney=$tmoney?$tmoney:0;
//今日签到人数
$sign=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzzc_sun_signlog')."where createtime >".$day." and uniacid = ".$_W['uniacid']);
//今日优惠券领取数
$coupon=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzzc_sun_coupon_get')."where createtime >".$day." and type = 2 and uniacid = ".$_W['uniacid']);
//今日租车券领取数
$rent=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzzc_sun_coupon_get')."where createtime >".$day." and type = 1  and uniacid = ".$_W['uniacid']);
include $this->template('web/index');