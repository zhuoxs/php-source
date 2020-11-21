<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {

    $id = intval($_GPC['id']);
    $activity = pdo_get($this->table_activity, array('id'=>$id,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        $this->result(1, '组织活动信息不存在！');
    }
    $branch = pdo_get($this->table_branch, array('id'=>$activity['branchid'],'uniacid'=>$_W['uniacid']));

    $actuser = pdo_get($this->table_user, array('id'=>$activity['userid'],'uniacid'=>$_W['uniacid']));

    $userid = intval($_GPC['userid']);
    $myuser = pdo_get($this->table_actenroll, array('userid'=>$userid,'activityid'=>$id,'uniacid'=>$_W['uniacid']));
    $myuser = empty($myuser) ? array() : $myuser;

    $userlist = pdo_fetchall("SELECT e.*, u.realname, u.headpic FROM ".tablename($this->table_actenroll)." e LEFT JOIN ".tablename($this->table_user)." u ON e.userid=u.id WHERE e.activityid=:activityid AND e.uniacid=:uniacid ORDER BY e.id ASC", array(':activityid'=>$id,':uniacid'=>$_W['uniacid']));
    if (!empty($userlist)) {
        foreach ($userlist as $k => $v) {
            $userlist[$k]['headpic'] = tomedia($v['headpic']);
        }
    }

    $usersubmitarr = array('status'=>false,'msg'=>"");
    if ($activity['status']==3) {
        $usersubmitarr['msg'] = "活动已结束";
    }elseif (!empty($myuser)) {
        $usersubmitarr['msg'] = "你已报名此活动";
    }elseif ($activity['endtime'] < time()) {
        $usersubmitarr['msg'] = "报名已截止";
    }elseif ($activity['utype']==2) {
        $usersubmitarr['msg'] = "该活动指定党员参与";
    }elseif ($activity['unumber']<=count($userlist)) {
        $usersubmitarr['msg'] = "报名人数已达上限";
    }else{
        $usersubmitarr['status'] = true;
        $usersubmitarr['msg'] = "我要报名参与";
    }

    $activity['details'] = str_replace('<img', '<img style="max-width:100%;height:auto" ', htmlspecialchars_decode($activity['details']));
    $activity['createtime'] = date("Y-m-d H:i", $activity['createtime']);
    $activity['endtime'] = date("Y-m-d H:i", $activity['endtime']);
    $activity['stime'] = date("Y-m-d H:i", $activity['stime']);
    $activity['etime'] = date("Y-m-d H:i", $activity['etime']);

    $this->result(0, '', array(
        'activity'      => $activity,
        'actuser'       => $actuser,
        'branch'        => $branch,
        'myuser'        => $myuser,
        'userlist'      => $userlist,
        'usersubmitarr' => $usersubmitarr
        ));


}elseif ($op=="usersubmit") {

    $userid = intval($_GPC['userid']);
    $activityid = intval($_GPC['activityid']);
    $activity = pdo_get($this->table_activity, array('id'=>$activityid,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        $this->result(1, '将要报名的组织活动不存在。');
    }
    if ($activity['status']==3) {
        $this->result(1, '该组织活动已结束。');
    }

    $actenrolltol = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_actenroll)." WHERE activityid=:activityid AND uniacid=:uniacid ", array(':activityid'=>$activityid,':uniacid'=>$_W['uniacid']));
    if ($actenrolltol>=$activity['unumber']) {
        $this->result(1, '报名人数已达上限。');
    }

    $myactenroll = pdo_get($this->table_actenroll,array('userid'=>$userid,'activityid'=>$activityid,'uniacid'=>$_W['uniacid']));
    if (!empty($myactenroll)) {
        $this->result(1, '该组织活动你已报名过了。');
    }

    if ($activity['utype']==2) {
        $this->result(1, '该组织活动为指定党员参与，你不能报名参与。');
    }
    $data = array(
        'uniacid'    => $_W['uniacid'],
        'activityid' => $activityid,
        'userid'     => $userid,
        'utype'      => 1,
        'getval'     => $activity['getval'],
        'createtime' => time(),
        'signintime' => 0
        );
    pdo_insert($this->table_actenroll, $data);
    $data['id'] = pdo_insertid();

    $userlist = pdo_fetchall("SELECT e.*, u.realname, u.headpic FROM ".tablename($this->table_actenroll)." e LEFT JOIN ".tablename($this->table_user)." u ON e.userid=u.id WHERE e.activityid=:activityid AND e.uniacid=:uniacid ORDER BY e.id ASC", array(':activityid'=>$activityid,':uniacid'=>$_W['uniacid']));
    if (!empty($userlist)) {
        foreach ($userlist as $k => $v) {
            $userlist[$k]['headpic'] = tomedia($v['headpic']);
        }
    }
    $usersubmitarr = array('status'=>false,'msg'=>"成功报名此活动");
    $this->result(0, '', array('myuser'=>$data,'userlist'=>$userlist,'usersubmitarr'=>$usersubmitarr));

}
?>