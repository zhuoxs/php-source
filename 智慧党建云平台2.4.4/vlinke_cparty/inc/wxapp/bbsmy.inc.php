<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'mytopic';


$userid = intval($_GPC['userid']);
$pindex = max(1, intval($_GPC['pindex']));
$psize = max(1, intval($_GPC['psize']));





if ($op=="mytopic") {

    $con = " WHERE tab.uniacid=:uniacid AND tab.userid=:userid ";
    $par[':uniacid'] = $_W['uniacid'];
    $par[':userid'] = $userid;
    $list = pdo_fetchall("SELECT tab.*, tab.id as topicid, u.realname, u.headpic FROM ".tablename($this->table_bbstopic)." tab LEFT JOIN ".tablename($this->table_user)." u ON tab.userid=u.id ".$con." ORDER BY tab.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, $par, "id");

}elseif ($op=="myreplyown") {

    $con = " WHERE tab.uniacid=:uniacid AND tab.userid=:userid ";
    $par[':uniacid'] = $_W['uniacid'];
    $par[':userid'] = $userid;
    $list = pdo_fetchall("SELECT tab.*, t.title, u.realname, u.headpic FROM ".tablename($this->table_bbsreply)." tab LEFT JOIN ".tablename($this->table_bbstopic)." t ON tab.topicid=t.id  LEFT JOIN ".tablename($this->table_user)." u ON t.userid=u.id ".$con." ORDER BY tab.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, $par, "id");

}elseif ($op=="myreplyother") {

    $con = " WHERE tab.uniacid=:uniacid AND t.userid=:userid ";
    $par[':uniacid'] = $_W['uniacid'];
    $par[':userid'] = $userid;
    $list = pdo_fetchall("SELECT tab.*, t.title, ru.realname as rrealname, u.realname, u.headpic FROM ".tablename($this->table_bbsreply)." tab LEFT JOIN ".tablename($this->table_user)." ru ON tab.userid=ru.id LEFT JOIN ".tablename($this->table_bbstopic)." t ON tab.topicid=t.id  LEFT JOIN ".tablename($this->table_user)." u ON t.userid=u.id ".$con." ORDER BY tab.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, $par, "id");

}elseif ($op=="mycollect") {

    $con = " WHERE tab.uniacid=:uniacid AND tab.userid=:userid ";
    $par[':uniacid'] = $_W['uniacid'];
    $par[':userid'] = $userid;
    $list = pdo_fetchall("SELECT tab.*, t.title, u.realname, u.headpic FROM ".tablename($this->table_bbscollect)." tab LEFT JOIN ".tablename($this->table_bbstopic)." t ON tab.topicid=t.id  LEFT JOIN ".tablename($this->table_user)." u ON t.userid=u.id ".$con." ORDER BY tab.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, $par, "id");


}elseif ($op=="myzan") {

    $con = " WHERE tab.uniacid=:uniacid AND tab.userid=:userid ";
    $par[':uniacid'] = $_W['uniacid'];
    $par[':userid'] = $userid;
    $list = pdo_fetchall("SELECT tab.*, t.title, u.realname, u.headpic FROM ".tablename($this->table_bbszan)." tab LEFT JOIN ".tablename($this->table_bbstopic)." t ON tab.topicid=t.id  LEFT JOIN ".tablename($this->table_user)." u ON t.userid=u.id ".$con." ORDER BY tab.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, $par, "id");

}



if (!empty($list)) {
    foreach ($list as $k => $v) {
        $list[$k]['headpic'] = tomedia($v['headpic']); 
        $list[$k]['createtime'] = date("Y-m-d H:i", $v['createtime']);
    }
}
$this->result(0, '', array_values($list));
?>