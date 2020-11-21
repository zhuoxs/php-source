<?php

global $_W,$_GPC;
yload()->classs('n1ce_mission','fans');
$fans = new Fans();
$rid = $_GPC['rid'];
$from_user = $_GPC['from_user'];
$pindex = max(1, intval($_GPC['page']));
$psize = 15;
$from_user_sql = "SELECT a.createtime, c.nickname, c.avatar,a.from_user, a.allnumber,b.uid,c.gender FROM " . tablename('n1ce_mission_allnumber') . " a LEFT JOIN "
        . tablename('mc_mapping_fans') . " b ON a.from_user = b.openid AND a.uniacid=b.uniacid LEFT JOIN "
        . tablename('mc_members') . " c ON b.uniacid = c.uniacid AND b.uid = c.uid  "
        . " WHERE rid=:rid AND a.uniacid=:uniacid AND from_user=:from_user";
$leader = pdo_fetch($from_user_sql,array(':rid'=>$rid,':uniacid'=>$_W['uniacid'],':from_user'=>$from_user));
if(empty($leader['avatar'])){
       $mcs = $fans->refresh($leader['from_user']);
       $leader['avatar'] = $mcs['avatar'];
       $leader['nickname'] = $mcs['nickname'];
       $leader['gender'] = $mcs['gender'];
}
$uplevel = pdo_fetch("select leader from " .tablename('n1ce_mission_follow'). " where uniacid=:uniacid and rid=:rid and follower=:follower",array(':rid'=>$rid,':uniacid'=>$_W['uniacid'],':follower'=>$from_user));
if($uplevel['leader']){
	$info = $fans->refresh($uplevel['leader']);
	$leader['uplevel'] = $info['nickname'];
}else{
	$leader['uplevel'] = "系统";
}
//下级列表
$follow_sql = "SELECT a.id,a.status,a.createtime, c.nickname, c.avatar,a.follower,b.uid,c.gender,b.follow FROM " . tablename('n1ce_mission_follow') . " a LEFT JOIN "
        . tablename('mc_mapping_fans') . " b ON a.follower = b.openid AND a.uniacid=b.uniacid LEFT JOIN "
        . tablename('mc_members') . " c ON b.uniacid = c.uniacid AND b.uid = c.uid  "
        . " WHERE rid=:rid AND a.uniacid=:uniacid AND leader=:leader order by createtime desc limit ". ($pindex - 1) * $psize . ',' . $psize;
$prarm = array(':uniacid' => $_W['uniacid'],':rid' => $rid,':leader'=>$from_user);
$follow_list = pdo_fetchall($follow_sql,$prarm);
foreach ($follow_list as &$item) {
        if(empty($item['uid']) || empty($item['avatar'])){
                
                $mc = $fans->refresh($item['from_user']);
                $item['uid'] = $mc['uid'];
                $item['avatar'] = $mc['avatar'];
                $item['nickname'] = $mc['nickname'];
                $item['gender'] = $mc['gender'];
        }
        unset($item);
}
$count = pdo_fetchcolumn('select count(*) from ' . tablename('n1ce_mission_follow') . 'where uniacid = :uniacid and rid = :rid and leader=:leader and status = 1', $prarm);
$pager = pagination($count, $pindex, $psize);
include $this->template('follow');