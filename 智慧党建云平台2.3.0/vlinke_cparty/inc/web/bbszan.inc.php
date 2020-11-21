<?php
global $_W, $_GPC;
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') { 
    $pindex = max(1, intval($_GPC['page']));
    $psize = 50;
    $con = ' WHERE tab.uniacid=:uniacid ';
    $par[':uniacid'] = $_W['uniacid'];
    $topicid = intval($_GPC['topicid']);
    if ($topicid!=0) {
        $con .= " AND tab.topicid=:topicid ";
        $par[':topicid'] = $topicid;
    }
    $cateid = intval($_GPC['cateid']);
    if ($cateid!=0) {
        $con .= " AND t.cateid=:cateid ";
        $par[':cateid'] = $cateid;
    }
    $title = trim($_GPC['title']);
    if (!empty($title)) {
        $con .= " AND t.title LIKE :title ";
        $par[':title'] = "%".$title."%";
    }
    $realname = trim($_GPC['realname']);
    if (!empty($realname)) {
        $con .= " AND u.realname=:realname ";
        $par[':realname'] = $realname;
    }
    $list = pdo_fetchall("SELECT tab.*,t.title,u.realname,u.mobile,u.headpic FROM ".tablename($this->table_bbszan)." tab LEFT JOIN ".tablename($this->table_bbstopic)." t ON tab.topicid=t.id LEFT JOIN ".tablename($this->table_user)." u ON tab.userid=u.id ".$con." ORDER BY tab.id DESC LIMIT ".($pindex-1) * $psize.",".$psize, $par, "id");
    $total = pdo_fetchcolumn("SELECT count(tab.id) FROM ".tablename($this->table_bbszan)." tab LEFT JOIN ".tablename($this->table_bbstopic)." t ON tab.topicid=t.id LEFT JOIN ".tablename($this->table_user)." u ON tab.userid=u.id ".$con ,$par);
    $pager = pagination($total, $pindex, $psize);
    
    $bbscate = pdo_getall($this->table_bbscate, array('uniacid'=>$_W['uniacid']));



} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $result = pdo_delete($this->table_bbszan, array('id' => $id));
    if (!empty($result)) {
        exit("success");
    }
    exit("error");

} elseif ($op == 'deleteall') {
    $idstr = implode(",", $_GPC['idArr']);
    $result = pdo_query("delete from ".tablename($this->table_bbszan)." WHERE id IN (".$idstr.")");
    if (!empty($result)) {
        exit("success");
    }
    exit("error");

}
include $this->template('bbszan');
?>