<?php
global $_W, $_GPC;
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') { 
    $pindex = max(1, intval($_GPC['page']));
    $psize = 50;
    $con = " WHERE t.uniacid=:uniacid AND c.branchid IN (".$lbrancharrid.") ";
    $par[':uniacid'] = $_W['uniacid'];
    $branchid = intval($_GPC['branchid']);
    if ($branchid!=0) {
        $con .= " AND u.branchid=:branchid ";
        $par[':branchid'] = $branchid;
        $branch = pdo_get($this->table_branch,array('id'=>$branchid,'uniacid'=>$_W['uniacid']));
    }
    $cateid = intval($_GPC['cateid']);
    if ($cateid!=0) {
        $con .= " AND t.cateid=:cateid ";
        $par[':cateid'] = $cateid;
    }
    $realname = trim($_GPC['realname']);
    if (!empty($realname)) {
        $con .= " AND u.realname=:realname ";
        $par[':realname'] = $realname;
    }

    $list = pdo_fetchall("SELECT t.*,u.realname,u.mobile FROM ".tablename($this->table_bbstopic)." t LEFT JOIN ".tablename($this->table_bbscate)." c ON t.cateid=c.id LEFT JOIN ".tablename($this->table_user)." u ON t.userid=u.id ".$con." ORDER BY t.id DESC LIMIT ".($pindex-1) * $psize.",".$psize, $par, "id");
    $total = pdo_fetchcolumn("SELECT count(t.id) FROM ".tablename($this->table_bbstopic)." t LEFT JOIN ".tablename($this->table_bbscate)." c ON t.cateid=c.id LEFT JOIN ".tablename($this->table_user)." u ON t.userid=u.id ".$con ,$par);
    $pager = pagination($total, $pindex, $psize);

    if (!empty($list)) {
        $idstr = implode(",", array_keys($list));
        $zantol = pdo_fetchall("SELECT count(id) as tol, topicid FROM ".tablename($this->table_bbszan)." WHERE topicid IN (".$idstr.") AND uniacid=:uniacid GROUP BY topicid ", array(':uniacid'=>$_W['uniacid']), "topicid");
        $replytol = pdo_fetchall("SELECT count(id) as tol, topicid FROM ".tablename($this->table_bbsreply)." WHERE topicid IN (".$idstr.") AND uniacid=:uniacid GROUP BY topicid ", array(':uniacid'=>$_W['uniacid']), "topicid");
        $collecttol = pdo_fetchall("SELECT count(id) as tol, topicid FROM ".tablename($this->table_bbscollect)." WHERE topicid IN (".$idstr.") AND uniacid=:uniacid GROUP BY topicid ", array(':uniacid'=>$_W['uniacid']), "topicid");
        foreach ($list as $k => $v) {
            $list[$k]['picall'] = iunserializer($v['picall']);
            $list[$k]['replyarr'] = pdo_fetchall("SELECT r.*,u.realname FROM ".tablename($this->table_bbsreply)." r LEFT JOIN ".tablename($this->table_user)." u ON r.userid=u.id WHERE r.topicid=:topicid AND r.uniacid=:uniacid ORDER BY r.id DESC ", array(':topicid'=>$v['id'],':uniacid'=>$_W['uniacid']));
        }
    }
    $bbscate = pdo_fetchall("SELECT * FROM ".tablename($this->table_bbscate)." WHERE branchid IN (".$lbrancharrid.") AND uniacid=:uniacid " , array(':uniacid'=>$_W['uniacid']),"id");


} elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    $bbstopic = pdo_fetch("SELECT * FROM ".tablename($this->table_bbstopic)." WHERE id=:id AND uniacid=:uniacid ",array(':id'=>$id,':uniacid'=>$_W['uniacid']));
    if (empty($bbstopic)) {
        message_tip('要编辑的话题信息不存在，请重新选择进入！', referer(), 'error');
    }
    
    if (checksubmit('submit')) {
        $data = array(
            'uniacid'    => $_W['uniacid'],
            'cateid'     => intval($_GPC['cateid']),
            'title'      => trim($_GPC['title']),
            'details'    => trim($_GPC['details']),
            'picall'     => iserializer($_GPC['picall']),
            'vpath'      => ""
            );
        pdo_update($this->table_bbstopic, $data, array('id'=>$id));
        message_tip('话题信息编辑成功！', referer(), 'success');
    }
    $bbstopic['picall'] = iunserializer($bbstopic['picall']);
    $user = pdo_get($this->table_user, array('id'=>$bbstopic['userid']));
    $bbscate = pdo_fetchall("SELECT * FROM ".tablename($this->table_bbscate)." WHERE branchid IN (".$lbrancharrid.") AND uniacid=:uniacid " , array(':uniacid'=>$_W['uniacid']),"id");


} elseif ($op == 'delreply') {
    $id = intval($_GPC['id']);
    $bbsreply = pdo_fetch("SELECT r.*,c.branchid FROM ".tablename($this->table_bbsreply)." r LEFT JOIN ".tablename($this->table_bbstopic)." t ON r.topicid=t.id LEFT JOIN ".tablename($this->table_bbscate)." c ON t.cateid=c.id WHERE r.id=:id AND c.branchid IN (".$lbrancharrid.") AND r.uniacid=:uniacid ",array(':id'=>$id,':uniacid'=>$_W['uniacid']));
    if (empty($bbsreply)) {
        exit("error");
    }
    $result = pdo_delete($this->table_bbsreply, array('id' => $id));
    if (!empty($result)) {
        exit("success");
    }
    exit("error");

} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $bbstopic = pdo_fetch("SELECT t.*,c.branchid FROM ".tablename($this->table_bbstopic)." t LEFT JOIN ".tablename($this->table_bbscate)." c ON t.cateid=c.id WHERE t.id=:id AND c.branchid IN (".$lbrancharrid.") AND t.uniacid=:uniacid ",array(':id'=>$id,':uniacid'=>$_W['uniacid']));
    if (empty($bbstopic)) {
        message_tip('要删除的话题信息不存在或是已经被删除！', referer(), 'error');
    }
    pdo_delete($this->table_bbszan, array('topicid' => $id));
    pdo_delete($this->table_bbsreply, array('topicid' => $id));
    pdo_delete($this->table_bbscollect, array('topicid' => $id));
    pdo_delete($this->table_bbstopic, array('id' => $id));
    message_tip('话题信息删除成功！', referer(), 'success');

}
include $this->template('admin/bbstopic');
?>