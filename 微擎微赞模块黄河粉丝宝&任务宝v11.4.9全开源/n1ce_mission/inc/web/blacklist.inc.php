<?php
global $_W,$_GPC;
$pindex = max(1, intval($_GPC['page']));
$psize = 15;
//查看拉黑
$allnumber_sql = "SELECT a.from_user,a.access_time, c.nickname, c.avatar,b.uid,b.follow,c.gender FROM " . tablename('n1ce_mission_blacklist') . " a LEFT JOIN "
. tablename('mc_mapping_fans') . " b ON a.from_user = b.openid AND a.uniacid=b.uniacid LEFT JOIN "
. tablename('mc_members') . " c ON b.uniacid = c.uniacid AND b.uid = c.uid  "
. " WHERE a.uniacid=:uniacid ORDER BY a.access_time DESC LIMIT ". ($pindex - 1) * $psize . ',' . $psize;
$prarm = array(':uniacid' => $_W['uniacid']);
$list = pdo_fetchall($allnumber_sql, $prarm);
$count = pdo_fetchcolumn('select count(*) from ' . tablename('n1ce_mission_blacklist') . 'where uniacid = :uniacid', $prarm);
$pager = pagination($count, $pindex, $psize);
include $this->template('blacklist');