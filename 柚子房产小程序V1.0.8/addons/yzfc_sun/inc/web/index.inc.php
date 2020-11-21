<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();


$day = strtotime(date('Y-m-d',time()));//获取今天凌晨的时间戳
$time1=strtotime(date("Y-m-d",strtotime("+1 day")));//获取明天凌晨的时间戳
$time2=strtotime(date("Y-m-d",strtotime("-1 day")));//获取昨天凌晨的时间戳
$time3=strtotime(date("Y-m"));//当月
/************************************************会员*****************************************************/
//会员总数
$alluser= pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzfc_sun_user')."where uniacid = ".$_W['uniacid']);
//今日新增会员
$todayuser=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzfc_sun_user')."where time >".$day." and uniacid = ".$_W['uniacid']);
//昨日新增
$yesterdayuser=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzfc_sun_user')."where time between ".$time2 ." and ".$day ." and uniacid = ".$_W['uniacid']);
//本月新增
$monthuser=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzfc_sun_user')."where time >".$time3 ." and uniacid = ".$_W['uniacid']);

/************************************************楼盘*****************************************************/
//预约总数
$allorder=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzfc_sun_house_order')."where uniacid = ".$_W['uniacid']);
//楼盘总数
$allhouse=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzfc_sun_house')."where  uniacid = ".$_W['uniacid'].' and status = 1');

/************************************************集卡活动*****************************************************/

$cardjoin=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzfc_sun_card_getlog')."where uniacid = ".$_W['uniacid']);
$cardprize=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzfc_sun_card_prizelog')."where uniacid = ".$_W['uniacid']);

/************************************************其他数据*****************************************************/

//分店总数
$branch=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzfc_sun_branch')."where uniacid = ".$_W['uniacid']." and status =1") ;
//今日发现数
$todayfind=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzfc_sun_find')."where uniacid = ".$_W['uniacid'].' and createtime >'.$day);
//今日预约
$todayorder=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzfc_sun_house_order')."where createtime >".$day." and uniacid = ".$_W['uniacid']);
////今日问答
$todayquestion=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzfc_sun_question')."where createtime >".$day." and uniacid = ".$_W['uniacid']." and status = 1");
//今日领奖
$todayprize=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzfc_sun_card_prizelog')."where createtime >".$day." and uniacid = ".$_W['uniacid']);
////广告报名总数
//$todayadsign=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzfc_sun_indexad_sign')."where createtime >".$day." and uniacid = ".$_W['uniacid']);
include $this->template('web/index');