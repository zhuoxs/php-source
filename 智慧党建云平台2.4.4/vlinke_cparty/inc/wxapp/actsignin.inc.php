<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if (empty($_W['openid'])) {
    $this->result(41009, '请先登录');
}

if ($op=="display") {
    
    $param = pdo_get($this->table_param,array('uniacid'=>$_W['uniacid']));
    if (empty($param)) {
        $this->result(1, '请先配置基本信息');
    }
    $user = pdo_get($this->table_user, array('recycle'=>0,'wxappopenid'=>$_W['openid'],'uniacid'=>$_W['uniacid']));
    if (empty($user)) {
        $this->result(1, '个人信息不存在，请先登录！');
    }
    
    $activityid = intval($_GPC['activityid']);
    $activity = pdo_get($this->table_activity, array('id'=>$activityid,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        $this->result(1, '组织活动不存在！');
    }

    $actenroll = pdo_get($this->table_actenroll, array('activityid'=>$activityid,'userid'=>$user['id'],'uniacid'=>$_W['uniacid']));
    if (empty($actenroll)) {
        $this->result(1, '你还未报名该活动，不能签到！');
    }
    if ($actenroll['signintime']) {
        $actenroll['signintime'] = date("Y-m-d H:i", $actenroll['signintime']);
    }

    $activity['details'] = str_replace('<img', '<img style="max-width:100%;height:auto" ', htmlspecialchars_decode($activity['details']));
    $activity['createtime'] = date("Y-m-d H:i", $activity['createtime']);
    $activity['endtime'] = date("Y-m-d H:i", $activity['endtime']);
    $activity['stime'] = date("Y-m-d H:i", $activity['stime']);
    $activity['etime'] = date("Y-m-d H:i", $activity['etime']);

    $branch = pdo_get($this->table_branch, array('id'=>$activity['branchid'],'uniacid'=>$_W['uniacid']));
    $actuser = pdo_get($this->table_user,array('id'=>$activity['userid'],'uniacid'=>$_W['uniacid']));
    $this->result(0, '', array(
        'activity'  => $activity,
        'branch'    => $branch,
        'actuser'   => $actuser,
        'param'     => $param,
        'user'      => $user,
        'actenroll' => $actenroll
        ));

}elseif ($op=="setsign") {
    $activityid = intval($_GPC['activityid']);
    $userid = intval($_GPC['userid']);
    $activity = pdo_get($this->table_activity, array('id'=>$activityid,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if ($activity['issign']==0) {
        $this->result(1, '该活动签到入口已关闭！');
    }

    $actenroll = pdo_get($this->table_actenroll,array('userid'=>$userid,'activityid'=>$activityid,'uniacid'=>$_W['uniacid']));
    if (empty($actenroll)) {
        $this->result(1, '你还未报名该活动，不能签到！');
    }
    if ($actenroll['signintime']>0) {
        $this->result(1, '你已签过到了，请不要重复签到！');
    }
    
    $signintime = time();
    pdo_update($this->table_actenroll, array('signintime'=>$signintime), array('id'=>$actenroll['id']));
    if ($activity['getval']>0) {
        $intdata = array(
            'userid'    => $userid,
            'channel'   => "actenroll",
            'foreignid' => $actenroll['id'],
            'integral'  => $activity['getval'],
            'remark'    => "参与《".$activity['title']."》活动奖励",
            );
        $this->setIntegral($intdata);
    }

    $activity['details'] = str_replace('<img', '<img style="max-width:100%;height:auto" ', htmlspecialchars_decode($activity['details']));
    $activity['createtime'] = date("Y-m-d H:i", $activity['createtime']);
    $activity['endtime'] = date("Y-m-d H:i", $activity['endtime']);
    $activity['stime'] = date("Y-m-d H:i", $activity['stime']);
    $activity['etime'] = date("Y-m-d H:i", $activity['etime']);

    
    $actenroll['signintime'] = date("Y-m-d H:i", $signintime);
    $this->result(0, '', array(
        'activity'  => $activity,
        'actenroll' => $actenroll
        ));


}
?>