<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {

    $id = intval($_GPC['id']);
    $topic = pdo_fetch("SELECT tab.*, c.name as cname, u.realname, u.headpic, b.name as bname FROM ".tablename($this->table_bbstopic)." tab LEFT JOIN ".tablename($this->table_bbscate)." c ON tab.cateid=c.id LEFT JOIN ".tablename($this->table_user)." u ON tab.userid=u.id LEFT JOIN ".tablename($this->table_branch)." b ON u.branchid=b.id WHERE tab.id=:id AND tab.uniacid=:uniacid ", array(':id'=>$id,':uniacid'=>$_W['uniacid']));
    if (empty($topic)) {
        message("话题不存在！",referer(),'error');
    }
    $topic['picall'] = iunserializer($topic['picall']);

    $zanarr = pdo_fetchall("SELECT tab.*, u.realname, u.headpic FROM ".tablename($this->table_bbszan)." tab LEFT JOIN ".tablename($this->table_user)." u ON tab.userid=u.id WHERE tab.topicid=:topicid AND tab.uniacid=:uniacid ORDER BY tab.id DESC ", array(':topicid'=>$id,':uniacid'=>$_W['uniacid']));
    $replyarr = pdo_fetchall("SELECT tab.*, u.realname, u.headpic FROM ".tablename($this->table_bbsreply)." tab LEFT JOIN ".tablename($this->table_user)." u ON tab.userid=u.id WHERE tab.topicid=:topicid AND tab.uniacid=:uniacid ORDER BY tab.id ASC ", array(':topicid'=>$id,':uniacid'=>$_W['uniacid']));

    $uzan = pdo_get($this->table_bbszan, array('topicid'=>$id,'userid'=>$user['id']));
    $ucollect = pdo_get($this->table_bbscollect, array('topicid'=>$id,'userid'=>$user['id']));


}elseif ($op=="clickcollect") {
    $id = intval($_GPC['id']);
    $bbscollect = pdo_get($this->table_bbscollect, array('userid'=>$user['id'],'topicid'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($bbscollect)) {
        $data = array(
            'uniacid'    => $_W['uniacid'],
            'topicid'    => $id,
            'userid'     => $user['id'],
            'createtime' => time()
            );
        pdo_insert($this->table_bbscollect, $data);
        $ucollect = pdo_insertid();
    }else{
        pdo_delete($this->table_bbscollect, array('userid'=>$user['id'],'topicid'=>$id,'uniacid'=>$_W['uniacid']));
        $ucollect = 0;
    }
    exit(json_encode($ucollect));


}elseif ($op=="clickzan") {
    $id = intval($_GPC['id']);
    $bbszan = pdo_get($this->table_bbszan, array('userid'=>$user['id'],'topicid'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($bbszan)) {
        $data = array(
            'uniacid'    => $_W['uniacid'],
            'topicid'    => $id,
            'userid'     => $user['id'],
            'createtime' => time()
            );
        pdo_insert($this->table_bbszan, $data);
        $uzan = pdo_insertid();
    }else{
        pdo_delete($this->table_bbszan, array('userid'=>$user['id'],'topicid'=>$id,'uniacid'=>$_W['uniacid']));
        $uzan = 0;
    }
    $zanarr = pdo_fetchall("SELECT tab.*, u.realname, u.headpic FROM ".tablename($this->table_bbszan)." tab LEFT JOIN ".tablename($this->table_user)." u ON tab.userid=u.id WHERE tab.topicid=:topicid AND tab.uniacid=:uniacid ORDER BY tab.id DESC ", array(':topicid'=>$id,':uniacid'=>$_W['uniacid']));
    exit(json_encode(array('uzan'=>$uzan,'zanarr'=>$zanarr)));


}elseif ($op=="replypost") {
	$ret = array('status'=>"error",'msg'=>"error",'reply'=>array());
    $id = intval($_GPC['id']);
    $details = trim($_GPC['details']);
    if (empty($id) || empty($details)) {
    	$ret['msg'] = "评论信息不完整，提交失败！";
    	exit(json_encode($ret));
    }
    $reply = array(
        'uniacid'    => $_W['uniacid'],
        'topicid'    => $id,
        'userid'     => $user['id'],
        'details'    => $details,
        'islook'     => 0,
        'createtime' => time()
        );
    pdo_insert($this->table_bbsreply, $reply);
    $reply['id'] = pdo_insertid();
    $reply['details'] = str_replace("\n","<br/>",$reply['details']);
    $ret['status'] = "success";
    $ret['msg'] = "success";
    $ret['reply'] = $reply;
    exit(json_encode($ret));

}elseif ($op=="replydelete") {
	$ret = array('status'=>"error",'msg'=>"error");
    $replyid = intval($_GPC['replyid']);
    $reply = pdo_get($this->table_bbsreply, array('id'=>$replyid,'userid'=>$user['id'],'uniacid'=>$_W['uniacid']));
    if (empty($replyid) || empty($reply)) {
        $ret['msg'] = "要删除的评论信息不存在，请重试！";
    	exit(json_encode($ret));
    }
    pdo_delete($this->table_bbsreply, array('id'=>$replyid,'userid'=>$user['id'],'uniacid'=>$_W['uniacid']));
    $ret['status'] = "success";
    $ret['msg'] = "success";
    exit(json_encode($ret));

}

include $this->template('bbstopic');

?>