<?php
global $_W,$_GPC;
$param = $this->getParam();
$user = $this->getUser();

$op = $_GPC['op']?$_GPC['op']:'mytopic';

$userid = $user['id'];
$pindex = max(1, intval($_GPC['page']));
$psize = 20;

$pagetitle = "党员论坛";

if ($op=="mytopic") {

    $pagetitle = "我发表的";

}elseif ($op=="mytopicmore") {

    $con = " WHERE tab.uniacid=:uniacid AND tab.userid=:userid ";
    $par[':uniacid'] = $_W['uniacid'];
    $par[':userid'] = $userid;
    $list = pdo_fetchall("SELECT tab.*, tab.id as topicid, u.realname, u.headpic FROM ".tablename($this->table_bbstopic)." tab LEFT JOIN ".tablename($this->table_user)." u ON tab.userid=u.id ".$con." ORDER BY tab.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, $par, "id");
    if (empty($list)) { exit("NOTHAVE"); }

}elseif ($op=="myreplyown") {

    $pagetitle = "我评论的";

}elseif ($op=="myreplyownmore") {

    $con = " WHERE tab.uniacid=:uniacid AND tab.userid=:userid ";
    $par[':uniacid'] = $_W['uniacid'];
    $par[':userid'] = $userid;
    $list = pdo_fetchall("SELECT tab.*, t.title, u.realname, u.headpic FROM ".tablename($this->table_bbsreply)." tab LEFT JOIN ".tablename($this->table_bbstopic)." t ON tab.topicid=t.id  LEFT JOIN ".tablename($this->table_user)." u ON t.userid=u.id ".$con." ORDER BY tab.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, $par, "id");
    if (empty($list)) { exit("NOTHAVE"); }

}elseif ($op=="myreplyother") {

    $pagetitle = "回复我的";

}elseif ($op=="myreplyothermore") {

    $con = " WHERE tab.uniacid=:uniacid AND t.userid=:userid ";
    $par[':uniacid'] = $_W['uniacid'];
    $par[':userid'] = $userid;
    $list = pdo_fetchall("SELECT tab.*, t.title, ru.realname as rrealname, u.realname, u.headpic FROM ".tablename($this->table_bbsreply)." tab LEFT JOIN ".tablename($this->table_user)." ru ON tab.userid=ru.id LEFT JOIN ".tablename($this->table_bbstopic)." t ON tab.topicid=t.id  LEFT JOIN ".tablename($this->table_user)." u ON t.userid=u.id ".$con." ORDER BY tab.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, $par, "id");
    if (empty($list)) { exit("NOTHAVE"); }

}elseif ($op=="mycollect") {

    $pagetitle = "我收藏的";

}elseif ($op=="mycollectmore") {

    $con = " WHERE tab.uniacid=:uniacid AND tab.userid=:userid ";
    $par[':uniacid'] = $_W['uniacid'];
    $par[':userid'] = $userid;
    $list = pdo_fetchall("SELECT tab.*, t.title, u.realname, u.headpic FROM ".tablename($this->table_bbscollect)." tab LEFT JOIN ".tablename($this->table_bbstopic)." t ON tab.topicid=t.id  LEFT JOIN ".tablename($this->table_user)." u ON t.userid=u.id ".$con." ORDER BY tab.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, $par, "id");
    if (empty($list)) { exit("NOTHAVE"); }

}elseif ($op=="myzan") {

    $pagetitle = "我点赞的";

}elseif ($op=="myzanmore") {

    $con = " WHERE tab.uniacid=:uniacid AND tab.userid=:userid ";
    $par[':uniacid'] = $_W['uniacid'];
    $par[':userid'] = $userid;
    $list = pdo_fetchall("SELECT tab.*, t.title, u.realname, u.headpic FROM ".tablename($this->table_bbszan)." tab LEFT JOIN ".tablename($this->table_bbstopic)." t ON tab.topicid=t.id  LEFT JOIN ".tablename($this->table_user)." u ON t.userid=u.id ".$con." ORDER BY tab.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, $par, "id");
    if (empty($list)) { exit("NOTHAVE"); }

}



include $this->template('bbsmy');

?>