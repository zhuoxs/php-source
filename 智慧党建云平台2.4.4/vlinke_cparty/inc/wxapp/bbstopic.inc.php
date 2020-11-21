<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {

    $id = intval($_GPC['id']);
    $topic = pdo_fetch("SELECT tab.*, c.name as cname, u.realname, u.headpic, b.name as bname FROM ".tablename($this->table_bbstopic)." tab LEFT JOIN ".tablename($this->table_bbscate)." c ON tab.cateid=c.id LEFT JOIN ".tablename($this->table_user)." u ON tab.userid=u.id LEFT JOIN ".tablename($this->table_branch)." b ON u.branchid=b.id WHERE tab.id=:id AND tab.uniacid=:uniacid ", array(':id'=>$id,':uniacid'=>$_W['uniacid']));
    if (empty($topic)) {
        $this->result(1, '话题不存在！');
    }
    $topic['headpic'] = tomedia($topic['headpic']);
    $topic['createtime'] = date("Y-m-d H:i", $topic['createtime']);
    $topic['picall'] = iunserializer($topic['picall']);
    if (!empty($topic['picall'])) {
        foreach ($topic['picall'] as $key => $value) {
            $topic['picall'][$key] = tomedia($value);
        }
    }

    $userid = intval($_GPC['userid']);
    $zanarr = pdo_fetchall("SELECT tab.*, u.realname, u.headpic FROM ".tablename($this->table_bbszan)." tab LEFT JOIN ".tablename($this->table_user)." u ON tab.userid=u.id WHERE tab.topicid=:topicid AND tab.uniacid=:uniacid ORDER BY tab.id DESC ", array(':topicid'=>$id,':uniacid'=>$_W['uniacid']));
    $uzan = 0;
    if (!empty($zanarr)) {
        foreach ($zanarr as $k => $v) {
            if ($v['userid']==$userid) {
                $uzan = $v['id'];
            }
        }
    }
    $replyarr = pdo_fetchall("SELECT tab.*, u.realname, u.headpic FROM ".tablename($this->table_bbsreply)." tab LEFT JOIN ".tablename($this->table_user)." u ON tab.userid=u.id WHERE tab.topicid=:topicid AND tab.uniacid=:uniacid ORDER BY tab.id ASC ", array(':topicid'=>$id,':uniacid'=>$_W['uniacid']));
    $ucollect = pdo_getcolumn($this->table_bbscollect, array('topicid'=>$id,'userid'=>$userid,'uniacid'=>$_W['uniacid']), "id");

    $this->result(0, '', array(
        'topic' => $topic,
        'zanarr' => $zanarr,
        'zantol' => count($zanarr),
        'uzan' => $uzan,
        'replyarr' => $replyarr,
        'replytol' => count($replyarr),
        'ucollect' => intval($ucollect)
        ));


}elseif ($op=="clickcollect") {
    $id = intval($_GPC['id']);
    $userid = intval($_GPC['userid']);
    $bbscollect = pdo_get($this->table_bbscollect, array('userid'=>$userid,'topicid'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($bbscollect)) {
        $data = array(
            'uniacid'    => $_W['uniacid'],
            'topicid'    => $id,
            'userid'     => $userid,
            'createtime' => time()
            );
        pdo_insert($this->table_bbscollect, $data);
        $ucollect = pdo_insertid();
    }else{
        pdo_delete($this->table_bbscollect, array('userid'=>$userid,'topicid'=>$id,'uniacid'=>$_W['uniacid']));
        $ucollect = 0;
    }
    $this->result(0, '', array('ucollect'=>$ucollect));


}elseif ($op=="clickzan") {
    $id = intval($_GPC['id']);
    $userid = intval($_GPC['userid']);
    $bbszan = pdo_get($this->table_bbszan, array('userid'=>$userid,'topicid'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($bbszan)) {
        $data = array(
            'uniacid'    => $_W['uniacid'],
            'topicid'    => $id,
            'userid'     => $userid,
            'createtime' => time()
            );
        pdo_insert($this->table_bbszan, $data);
        $uzan = pdo_insertid();
    }else{
        pdo_delete($this->table_bbszan, array('userid'=>$userid,'topicid'=>$id,'uniacid'=>$_W['uniacid']));
        $uzan = 0;
    }
    $zanarr = pdo_fetchall("SELECT tab.*, u.realname, u.headpic FROM ".tablename($this->table_bbszan)." tab LEFT JOIN ".tablename($this->table_user)." u ON tab.userid=u.id WHERE tab.topicid=:topicid AND tab.uniacid=:uniacid ORDER BY tab.id DESC ", array(':topicid'=>$id,':uniacid'=>$_W['uniacid']));
    $this->result(0, '', array('uzan'=>$uzan,'zanarr'=>$zanarr,'zantol'=>count($zanarr)));

}elseif ($op=="replypost") {
    $id = intval($_GPC['id']);
    $userid = intval($_GPC['userid']);
    $details = trim($_GPC['details']);
    if (empty($userid) || empty($id) || empty($details)) {
        $this->result(1, '评论信息不完整，提交失败！');
    }
    $data = array(
        'uniacid'    => $_W['uniacid'],
        'topicid'    => $id,
        'userid'     => $userid,
        'details'    => $details,
        'islook'     => 0,
        'createtime' => time()
        );
    pdo_insert($this->table_bbsreply, $data);

    $replyarr = pdo_fetchall("SELECT tab.*, u.realname, u.headpic FROM ".tablename($this->table_bbsreply)." tab LEFT JOIN ".tablename($this->table_user)." u ON tab.userid=u.id WHERE tab.topicid=:topicid AND tab.uniacid=:uniacid ORDER BY tab.id ASC ", array(':topicid'=>$id,':uniacid'=>$_W['uniacid']));
    $this->result(0, '', array('replytol'=>count($replyarr),'replyarr'=>$replyarr));


}elseif ($op=="replydelete") {
    $userid = intval($_GPC['userid']);
    $replyid = intval($_GPC['replyid']);
    $reply = pdo_get($this->table_bbsreply, array('id'=>$replyid,'userid'=>$userid,'uniacid'=>$_W['uniacid']));
    if (empty($userid) || empty($replyid) || empty($reply)) {
        $this->result(1, '要删除的评论信息不存在，请重试！');
    }
    pdo_delete($this->table_bbsreply, array('id'=>$replyid,'userid'=>$userid,'uniacid'=>$_W['uniacid']));

    $replyarr = pdo_fetchall("SELECT tab.*, u.realname, u.headpic FROM ".tablename($this->table_bbsreply)." tab LEFT JOIN ".tablename($this->table_user)." u ON tab.userid=u.id WHERE tab.topicid=:topicid AND tab.uniacid=:uniacid ORDER BY tab.id ASC ", array(':topicid'=>$reply['topicid'],':uniacid'=>$_W['uniacid']));
    $this->result(0, '', array('replytol'=>count($replyarr),'replyarr'=>$replyarr));

}
?>