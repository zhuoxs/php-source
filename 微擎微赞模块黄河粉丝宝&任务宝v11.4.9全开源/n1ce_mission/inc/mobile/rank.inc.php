<?php
global $_W,$_GPC;
$mc = mc_oauth_userinfo();
$rid = $_GPC['rid'];
yload()->classs('n1ce_mission', 'fans');
$_fans = new Fans();
$from_user = $_fans->getRealOpenid($mc['openid'],$_SESSION['oauth_openid'],$rid,$this->module['config']['borrow'],$mc['unionid']);
$userInfo = $_fans->refresh($from_user);
$join = pdo_get('n1ce_mission_qrlog',array('uniacid'=>$_W['uniacid'],'rid'=>$rid,'from_user'=>$from_user),array('id'));
$reply = pdo_get('n1ce_mission_reply',array('uniacid'=>$_W['uniacid'],'rid'=>$rid),array('rank_num','tips','copyright'));
if(empty($join['id'])){
	message('你还未生成海报','','error');
}
$tips = $reply['tips']?$reply['tips']:$this->module['config']['tips'];
$copyright = $reply['copyright']?$reply['copyright']:$this->module['config']['copyright'];
$total_num = pdo_get('n1ce_mission_allnumber',array('uniacid'=>$_W['uniacid'],'rid'=>$rid,'from_user'=>$from_user),array('allnumber'));
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if($op == 'display'){
	$allnumber_sql = "SELECT a.createtime, c.nickname, c.avatar, a.from_user, a.allnumber,b.uid FROM " . tablename('n1ce_mission_allnumber') . " a LEFT JOIN "
    . tablename('mc_mapping_fans') . " b ON a.from_user = b.openid AND a.uniacid=b.uniacid LEFT JOIN "
    . tablename('mc_members') . " c ON b.uniacid = c.uniacid AND b.uid = c.uid  "
    . " WHERE rid=:rid AND a.uniacid=:uniacid ORDER BY allnumber DESC LIMIT ".$reply['rank_num'];
	$prarm = array(':uniacid' => $_W['uniacid'],':rid' => $rid);
	$list = pdo_fetchall($allnumber_sql, $prarm);
	foreach ($list as &$item) {
		if(empty($item['uid']) || empty($item['avatar'])){
			$mc = $_fans->refresh($item['from_user']);
			$item['uid'] = $mc['uid'];
			$item['avatar'] = $mc['avatar'];
			$item['nickname'] = $mc['nickname'];
		}
		unset($item);
	}
}elseif ($op == 'list') {
	# code...
	//下级列表
	$follow_sql = "SELECT a.createtime, c.nickname, c.avatar,a.follower,b.uid FROM " . tablename('n1ce_mission_follow') . " a LEFT JOIN "
	        . tablename('mc_mapping_fans') . " b ON a.follower = b.openid AND a.uniacid=b.uniacid LEFT JOIN "
	        . tablename('mc_members') . " c ON b.uniacid = c.uniacid AND b.uid = c.uid  "
	        . " WHERE rid=:rid AND a.uniacid=:uniacid AND leader=:leader AND status = 1 order by createtime desc";
	$prarm = array(':uniacid' => $_W['uniacid'],':rid' => $rid,':leader'=>$from_user);
	$follow_list = pdo_fetchall($follow_sql,$prarm);
	foreach ($follow_list as &$item) {
        if(empty($item['uid']) || empty($item['avatar'])){  
            $mc = $_fans->refresh($item['from_user']);
            $item['uid'] = $mc['uid'];
            $item['avatar'] = $mc['avatar'];
            $item['nickname'] = $mc['nickname'];
        }
        unset($item);
	}
}elseif ($op == 'tips') {
	# code...
}
include $this->template('n1ce_rank');