<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {
    $id = intval($_GPC['id']);
    $activity = pdo_get($this->table_activity, array('id'=>$id,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        message("组织活动信息不存在！",referer(),'error');
    }
    $branch = pdo_get($this->table_branch, array('id'=>$activity['branchid'],'uniacid'=>$_W['uniacid']));
    $actuser = pdo_get($this->table_user,array('id'=>$activity['userid'],'uniacid'=>$_W['uniacid']));

    $myactenroll = pdo_get($this->table_actenroll, array('userid'=>$user['id'],'activityid'=>$id,'uniacid'=>$_W['uniacid']));

    $actenroll = pdo_fetchall("SELECT e.*, u.realname, u.headpic FROM ".tablename($this->table_actenroll)." e LEFT JOIN ".tablename($this->table_user)." u ON e.userid=u.id WHERE e.activityid=:activityid AND e.uniacid=:uniacid ORDER BY e.id DESC", array(':activityid'=>$id,':uniacid'=>$_W['uniacid']));

    $actmessage = pdo_fetchall("SELECT m.*, u.realname, u.headpic FROM ".tablename($this->table_actmessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id WHERE m.activityid=:activityid AND m.uniacid=:uniacid ORDER BY m.id DESC LIMIT 6 ", array(':activityid'=>$id,':uniacid'=>$_W['uniacid']));
    if (!empty($actmessage)) {
        foreach ($actmessage as $k => $v) {
            $actmessage[$k]['picall'] = iunserializer($v['picall']);
        }
    }
    $actmessagetol = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_actmessage)." WHERE activityid=:activityid AND uniacid=:uniacid ", array(':activityid'=>$id,':uniacid'=>$_W['uniacid']));
    $actmessagetol = intval($actmessagetol);

}elseif ($op=="enroll") {
    $ret = array('status'=>"error",'msg'=>"error");
    $activityid = intval($_GPC['activityid']);
    $activity = pdo_get($this->table_activity, array('id'=>$activityid,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        $ret['msg'] = "将要报名的组织活动不存在！";
        exit(json_encode($ret));
    }
    if ($activity['status']==3) {
        $ret['msg'] = "该组织活动已结束！";
        exit(json_encode($ret));
    }

    $actenrolltol = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_actenroll)." WHERE activityid=:activityid AND uniacid=:uniacid ", array(':activityid'=>$activityid,':uniacid'=>$_W['uniacid']));
    if ($activity['unumber']>0 && $activityid>=$activity['unumber']) {
        $ret['msg'] = "报名人数已达上限！";
        exit(json_encode($ret));
    }

    $myactenroll = pdo_get($this->table_actenroll,array('userid'=>$user['id'],'activityid'=>$activityid,'uniacid'=>$_W['uniacid']));
    if (!empty($myactenroll)) {
        $ret['msg'] = "该组织活动你已报名过了！";
        exit(json_encode($ret));
    }

    if ($activity['utype']==2) {
        $ret['msg'] = "该组织活动为指定党员参与，你不能报名参与！";
        exit(json_encode($ret));
    }

    $data = array(
        'uniacid'    => $_W['uniacid'],
        'activityid' => $activityid,
        'userid'     => $user['id'],
        'utype'      => 1,
        'getval'     => $activity['getval'],
        'createtime' => time(),
        'signintime' => 0
        );
    pdo_insert($this->table_actenroll, $data);
    $ret['status'] = "success";
    $ret['msg'] = "组织活动报名成功！";
    exit(json_encode($ret));

}elseif ($op=="manage") {
    $activityid = intval($_GPC['activityid']);
    $activity = pdo_get($this->table_activity, array('id'=>$activityid,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        message("组织活动不存在！",referer(),'error');
    }
    if ($activity['userid']!=$user['id']) {
        message("非活动组织者，无权查看！",referer(),'error');
    }
    $branch = pdo_get($this->table_branch, array('id'=>$activity['branchid'],'uniacid'=>$_W['uniacid']));
    $actuser = pdo_get($this->table_user,array('id'=>$activity['userid'],'uniacid'=>$_W['uniacid']));

    $actenroll = pdo_fetchall("SELECT e.*, u.realname, u.headpic FROM ".tablename($this->table_actenroll)." e LEFT JOIN ".tablename($this->table_user)." u ON e.userid=u.id WHERE e.activityid=:activityid AND e.uniacid=:uniacid ORDER BY e.id DESC", array(':activityid'=>$activityid,':uniacid'=>$_W['uniacid']));

    $utype1 = array('sign'=>array(),'nosign'=>array());
    $utype2 = array('sign'=>array(),'nosign'=>array());
    foreach ($actenroll as $k => $v) {
        if ($v['utype']==1 && $v['signintime']>0) {
            $utype1['sign'][] = $v;
        }elseif ($v['utype']==1 && $v['signintime']==0) {
            $utype1['nosign'][] = $v;
        }elseif ($v['utype']==2 && $v['signintime']>0) {
            $utype2['sign'][] = $v;
        }elseif ($v['utype']==2 && $v['signintime']==0) {
            $utype2['nosign'][] = $v;
        }
    }

    $url = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."%26c=entry%26do=activity%26op=sign%26m=vlinke_cparty%26activityid=".$activityid;

}elseif ($op=="setsign") {
    $activityid = intval($_GPC['activityid']);
    $activity = pdo_get($this->table_activity, array('id'=>$activityid,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        message("组织活动不存在！", $this->createMobileUrl('home'), 'error');
    }
    if ($activity['issign']==0) {
        pdo_update($this->table_activity, array('issign'=>1), array('id'=>$activityid));
    }else{
        pdo_update($this->table_activity, array('issign'=>0), array('id'=>$activityid));
    }
    Header("Location:".$this->createMobileUrl('activity',array('op'=>'manage','activityid'=>$activityid)));

}elseif ($op=="sign") {
    $activityid = intval($_GPC['activityid']);
    $activity = pdo_get($this->table_activity, array('id'=>$activityid,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        message("组织活动不存在！", $this->createMobileUrl('home'), 'error');
    }
    if ($activity['issign']==0) {
        message("该活动签到端口已关闭！", $this->createMobileUrl('activity',array('id'=>$activityid)), 'error');
    }

    $myactenroll = pdo_get($this->table_actenroll,array('userid'=>$user['id'],'activityid'=>$activityid,'uniacid'=>$_W['uniacid']));
    if (empty($myactenroll)) {
        message("你还未报名该活动！", $this->createMobileUrl('activity',array('id'=>$activityid)), 'error');
    }
    if ($myactenroll['signintime']>0) {
        message("你已签过到了，请不要重复签到！", $this->createMobileUrl('activity',array('id'=>$activityid)), 'error');
    }

    pdo_update($this->table_actenroll, array('signintime'=>time()), array('id'=>$myactenroll['id']));
    if ($activity['getval']>0) {
        $intdata = array(
            'userid'    => $user['id'],
            'channel'   => "actenroll",
            'foreignid' => $myactenroll['id'],
            'integral'  => $activity['getval'],
            'remark'    => "参与《".$activity['title']."》活动奖励",
            );
        $this->setIntegral($intdata);
    }
    message("签到成功！", $this->createMobileUrl('activity',array('id'=>$activityid)), 'success');

}
include $this->template('activity');
?>