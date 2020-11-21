<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {
    $activityid = intval($_GPC['activityid']);
    $activity = pdo_get($this->table_activity, array('id'=>$activityid,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        message("组织活动信息不存在！",referer(),'error');
    }
    $branch = pdo_get($this->table_branch, array('id'=>$activity['branchid'],'uniacid'=>$_W['uniacid']));

    $actmessagetol = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_actmessage)." WHERE activityid=:activityid AND uniacid=:uniacid ", array(':activityid'=>$activityid,':uniacid'=>$_W['uniacid']));
    $actmessagetol = intval($actmessagetol);

}elseif ($op=="getmore") {
    $activityid = intval($_GPC['activityid']);
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall("SELECT m.*, u.realname, u.headpic FROM ".tablename($this->table_actmessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id WHERE m.activityid=:activityid AND m.uniacid=:uniacid ORDER BY m.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':activityid'=>$activityid,':uniacid'=>$_W['uniacid']));
    if (empty($list)) {
        exit("NOTHAVE");
    }
    foreach ($list as $k => $v) {
        $list[$k]['picall'] = iunserializer($v['picall']);
    }

}elseif ($op=="post") {
    $ret = array('status'=>"error",'msg'=>"error");
    $details = trim($_GPC['details']);
    if (empty($details)) {
        $ret['msg'] = "请输入留言内容！";
        exit(json_encode($ret));
    }
    $activityid = intval($_GPC['activityid']);
    $activity = pdo_get($this->table_activity, array('id'=>$activityid,'status'=>array(1,2),'uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        $ret['msg'] = "组织活动信息不存在！";
        exit(json_encode($ret));
    }
    $picall = empty($_GPC['picall'])?array():$_GPC['picall'];
    $data = array(
        'uniacid'    => $_W['uniacid'],
        'activityid' => $activityid,
        'userid'     => $user['id'],
        'details'    => $details,
        'picall'     => iserializer($picall),
        'createtime' => time()
        );
    pdo_insert($this->table_actmessage, $data);
    $ret['status'] = "success";
    $ret['msg'] = "留言信息提交成功！";
    exit(json_encode($ret));

}elseif ($op=="delete") {
    $ret = array('status'=>"error",'msg'=>"error");
    $id = intval($_GPC['id']);
    $actmessage = pdo_get($this->table_actmessage, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($actmessage)) {
        $ret['msg'] = "留言记录不存在！";
        exit(json_encode($ret));
    }
    if ($actmessage['userid']!=$user['id']) {
        $ret['msg'] = "该留言记录不是你所写，无权做删除操作！";
        exit(json_encode($ret));
    }
    pdo_delete($this->table_actmessage, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    $ret['status'] = "success";
    $ret['msg'] = "留言记录删除成功！";
    exit(json_encode($ret));

}
include $this->template('actmessage');
?>