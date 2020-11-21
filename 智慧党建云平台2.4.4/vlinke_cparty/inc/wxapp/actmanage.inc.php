<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {

    $activityid = intval($_GPC['activityid']);
    $activity = pdo_get($this->table_activity, array('id'=>$activityid,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        $this->result(1, '将要管理的组织活动不存在。');
    }
    $userid = intval($_GPC['userid']);
    if ($activity['userid']!=$userid) {
        $this->result(1, '非该活动组织者，无权管理签到。');
    }

    $branch = pdo_get($this->table_branch, array('id'=>$activity['branchid'],'uniacid'=>$_W['uniacid']));
    $actuser = pdo_get($this->table_user,array('id'=>$activity['userid'],'uniacid'=>$_W['uniacid']));

    $actenroll = pdo_fetchall("SELECT e.*, u.realname, u.headpic FROM ".tablename($this->table_actenroll)." e LEFT JOIN ".tablename($this->table_user)." u ON e.userid=u.id WHERE e.activityid=:activityid AND e.uniacid=:uniacid ORDER BY e.id ASC", array(':activityid'=>$activityid,':uniacid'=>$_W['uniacid']));

    $utype1 = array('sign'=>array(),'nosign'=>array(),'num'=>array('tol'=>0,'signtol'=>0,'nosigntol'=>0));
    $utype2 = array('sign'=>array(),'nosign'=>array(),'num'=>array('tol'=>0,'signtol'=>0,'nosigntol'=>0));
    foreach ($actenroll as $k => $v) {
        $v['headpic'] = tomedia($v['headpic']);
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
    $utype1['num']['signtol'] = count($utype1['sign']);
    $utype1['num']['nosigntol'] = count($utype1['nosign']);
    $utype1['num']['tol'] = $utype1['num']['signtol'] + $utype1['num']['nosigntol'];
    $utype2['num']['signtol'] = count($utype2['sign']);
    $utype2['num']['nosigntol'] = count($utype2['nosign']);
    $utype2['num']['tol'] = $utype2['num']['signtol'] + $utype2['num']['nosigntol'];
    $actenrolltol = $utype1['num']['tol'] + $utype2['num']['tol'];

    $activity['createtime'] = date("Y-m-d H:i", $activity['createtime']);
    $activity['endtime'] = date("Y-m-d H:i", $activity['endtime']);
    $activity['stime'] = date("Y-m-d H:i", $activity['stime']);
    $activity['etime'] = date("Y-m-d H:i", $activity['etime']);

    if (empty($activity['wxappqrcode'])) {
        $account_api = WeAccount::create();
        $response = $account_api->getCodeUnlimit($activityid, 'vlinke_cparty/pages/act/actsignin', 430, array(
            'auto_color' => false,
            'line_color' => array(
                'r' => 0,
                'g' => 0,
                'b' => 0,
            ),
        ));
        $filename = "wxappqrcode".$activityid."_" . md5(time() . mt_rand(0,9999));
        $filetable = "images/vlinkecparty/".$_W['uniacid']."/".$filename.".png";
        $filepath = ATTACHMENT_ROOT."/images/vlinkecparty/".$_W['uniacid'];
        if (!file_exists(filepath)) {
            @mkdir($filepath,0777,true);
        }
        file_put_contents(ATTACHMENT_ROOT."/".$filetable, $response);
        pdo_update($this->table_activity, array('wxappqrcode'=>$filetable), array('id'=>$activityid));
        $wxappqrcode = tomedia($filetable);
    }else{
        $wxappqrcode = tomedia($activity['wxappqrcode']);
    }
    
    $this->result(0, '', array(
        'activity'     => $activity,
        'wxappqrcode'  => $wxappqrcode,
        'branch'       => $branch,
        'actuser'      => $actuser,
        'utype1'       => $utype1,
        'utype2'       => $utype2,
        'actenrolltol' => $actenrolltol
        ));


}elseif ($op=="refurbishqrcode") {
    
    $activityid = intval($_GPC['activityid']);
    $activity = pdo_get($this->table_activity, array('id'=>$activityid,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        $this->result(1, '组织活动不存在！');
    }

    $account_api = WeAccount::create();
    $response = $account_api->getCodeUnlimit($activityid, 'vlinke_cparty/pages/act/actsignin', 430, array(
        'auto_color' => false,
        'line_color' => array(
            'r' => 0,
            'g' => 0,
            'b' => 0,
        ),
    ));
    $filename = "wxappqrcode".$activityid."_" . md5(time() . mt_rand(0,9999));
    $filetable = "images/vlinkecparty/".$_W['uniacid']."/".$filename.".png";
    $filepath = ATTACHMENT_ROOT."/images/vlinkecparty/".$_W['uniacid'];
    if (!file_exists(filepath)) {
        @mkdir($filepath,0777,true);
    }
    file_put_contents(ATTACHMENT_ROOT."/".$filetable, $response);
    pdo_update($this->table_activity, array('wxappqrcode'=>$filetable), array('id'=>$activityid));
    $wxappqrcode = tomedia($filetable);

    $this->result(0, '', array(
        'wxappqrcode' => $wxappqrcode
        ));


}elseif ($op=="setsign") {
    $activityid = intval($_GPC['activityid']);
    $activity = pdo_get($this->table_activity, array('id'=>$activityid,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        $this->result(1, '组织活动不存在！');
    }
    $issign = $activity['issign']==0 ? 1 : 0;
    pdo_update($this->table_activity, array('issign'=>$issign), array('id'=>$activityid));
    $this->result(0, '', array(
        'issign' => $issign
        ));

}
?>
