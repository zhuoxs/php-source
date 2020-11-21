<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();


$day = strtotime(date('Y-m-d',time()));//获取今天凌晨的时间戳
$time1=strtotime(date("Y-m-d",strtotime("+1 day")));//获取明天凌晨的时间戳
$time2=strtotime(date("Y-m-d",strtotime("-1 day")));//获取昨天凌晨的时间戳
$time3=strtotime(date("Y-m"));//当月
/************************************************会员*****************************************************/
//会员总数
$alluser= pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzpx_sun_user')."where uniacid = ".$_W['uniacid']);
//今日新增会员
$todayuser=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzpx_sun_user')."where time >".$day." and uniacid = ".$_W['uniacid']);
//昨日新增
$yesterdayuser=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzpx_sun_user')."where time between ".$time2 ." and ".$day ." and uniacid = ".$_W['uniacid']);
//本月新增
$monthuser=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzpx_sun_user')."where time >".$time3 ." and uniacid = ".$_W['uniacid']);

/************************************************课程*****************************************************/
//课程预约总数
$allorder=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzpx_sun_course_order')."where uniacid = ".$_W['uniacid']);
//课程报名总数
$allsign=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzpx_sun_course_sign')."where  uniacid = ".$_W['uniacid'].' and ispay = 1');

/************************************************集卡活动*****************************************************/

$cardjoin=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzpx_sun_card_getlog')."where uniacid = ".$_W['uniacid']);
$cardprize=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzpx_sun_card_prizelog')."where uniacid = ".$_W['uniacid']);

/************************************************其他数据*****************************************************/

//老师总数
$teacher=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzpx_sun_teacher')."where uniacid = ".$_W['uniacid']." and status =1") ;
//今日课程数
$todaycourse=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzpx_sun_lesson')."where uniacid = ".$_W['uniacid'].' and start_time >'.$day .' and end_time <'.$time1);
//今日预约
$todayorder=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzpx_sun_course_order')."where createtime >".$day." and uniacid = ".$_W['uniacid']);
//今日报名
$todaysign=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzpx_sun_course_sign')."where createtime >".$day." and uniacid = ".$_W['uniacid']." and ispay = 1");
//今日领奖
$todayprize=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzpx_sun_card_prizelog')."where createtime >".$day." and uniacid = ".$_W['uniacid']);
//广告报名总数
$todayadsign=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzpx_sun_indexad_sign')."where createtime >".$day." and uniacid = ".$_W['uniacid']);
include $this->template('web/index');