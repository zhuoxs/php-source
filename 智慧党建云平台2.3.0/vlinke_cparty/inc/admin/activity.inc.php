<?php
global $_W, $_GPC;
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') { 
    $con = " WHERE uniacid=:uniacid AND branchid IN (".$lbrancharrid.") ";
    $par[':uniacid'] = $_W['uniacid'];
    $keywords = trim($_GPC['keywords']);
    if (!empty($keywords)) {
        $con .= " AND title LIKE :keywords ";
        $par[':keywords'] = '%'.$keywords.'%';
    }
    $status = intval($_GPC['status']);
    if ($status!=0) {
        $con .= " AND status=:status ";
        $par[':status'] = $status;
    }
    $utype = intval($_GPC['utype']);
    if ($utype!=0) {
        $con .= " AND utype=:utype ";
        $par[':utype'] = $utype;
    }
    if (isset($_GPC['branchid'])) {
        $con .= " AND branchid=:branchid ";
        $par[':branchid'] = intval($_GPC['branchid']);
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT * FROM '.tablename($this->table_activity).$con.' ORDER BY priority DESC, id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par);
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_activity).$con, $par);
    $pager = pagination($total, $pindex, $psize);

    $branchidarr = array_column($list,'branchid');
    $branch = pdo_getall($this->table_branch, array('id'=>$branchidarr,'uniacid'=>$_W['uniacid']), '', 'id');


} elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    $activity = pdo_get($this->table_activity, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (checksubmit('submit')) {
        $branchid = intval($_GPC['branchid']);
        if ( $branchid==0 ) {
            message_tip('发布组织不能为空！', referer(), 'error');
        }
        $utype = intval($_GPC['utype']);
        $data = array(
            'uniacid'  => $_W['uniacid'],
            'branchid' => $branchid,
            'title'    => trim($_GPC['title']),
            'tilpic'   => trim($_GPC['tilpic']),
            'stime'    => strtotime($_GPC['datelimit']['start']),
            'etime'    => strtotime($_GPC['datelimit']['end']),
            'address'  => trim($_GPC['address']),
            'details'  => $_GPC['details'],
            'getval'   => intval($_GPC['getval']),
            'status'   => intval($_GPC['status']),
            'utype'    => $utype,
            'unumber'  => intval($_GPC['unumber']),
            'endtime'  => strtotime($_GPC['endtime']),
            'priority' => intval($_GPC['priority']),
            'issign'   => intval($_GPC['issign']),
            'userid'   => intval($_GPC['userid']),
        );
        if (!empty($id)) {
            if ($utype==1 && $utype!=$activity['utype']) {
                pdo_update($this->table_actenroll, array('utype'=>1), array('activityid' => $id));
            }elseif ($utype==2 && $utype!=$activity['utype']) {
                pdo_update($this->table_actenroll, array('utype'=>2), array('activityid' => $id));
            }
            pdo_update($this->table_activity, $data, array('id' => $id));
        } else {
            $data['priority'] = 0;
            $data['createtime'] = time();
            pdo_insert($this->table_activity, $data);
            $id = pdo_insertid();
        }
        message_tip('信息更新成功！', $this->createWebUrl('admin',array('r'=>'activity')), 'success');
    }
    if (empty($activity)) {
        $activity = array(
            'stime'      => time(),
            'etime'      => time()+7*86400,
            'getval'     => 0, 
            'status'     => 2,
            'utype'      => 1,
            'unumber'    => 0,
            'endtime'    => time()+7*86400,
            'createtime' => time(),
            'priority'   => 0,
            'issign'     => 0
        );
    }else{
        $branch = $lbranchall[$activity['branchid']];
        if (empty($branch)) {
            message_tip("你无权限管理该活动信息！", $this->createWebUrl('admin', array('r'=>'activity')), 'error');
        }

        $branch = pdo_get($this->table_branch,array('id'=>$activity['branchid'],'uniacid'=>$_W['uniacid']));
        $user = pdo_get($this->table_user,array('id'=>$activity['userid'],'uniacid'=>$_W['uniacid']));
    }
    $param = pdo_get($this->table_param,array('uniacid'=>$_W['uniacid']));

} elseif ($op == 'add') {
    $id = intval($_GPC['id']);
    $activity = pdo_fetch("SELECT * FROM ".tablename($this->table_activity)." WHERE id=:id AND branchid IN (".$lbrancharrid.") AND uniacid=:uniacid LIMIT 1 ", array(':id'=>$id,':uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        message_tip('你无权限操作该活动信息！', referer(), 'error');
    }
    $branch = pdo_get($this->table_branch, array('id'=>$activity['branchid'],'uniacid'=>$_W['uniacid']), '', 'id');
    $utypearr = array(1=>"自由报名",2=>"指定党员",3=>"指定党员&自由报名");
    $list = pdo_fetchall("SELECT e.*,u.nickname,u.realname,u.mobile,u.headpic FROM ".tablename($this->table_actenroll)." e LEFT JOIN ".tablename($this->table_user)." u ON e.userid=u.id WHERE e.uniacid=:uniacid AND e.activityid=:activityid ORDER BY e.createtime DESC ", array(':uniacid'=>$_W['uniacid'],':activityid'=>$id));

} elseif ($op == 'searchuser') {
    $ret = "";
    $con = ' WHERE u.uniacid=:uniacid AND u.recycle=0 ';
    $par[':uniacid'] = $_W['uniacid'];
    $keyword = $_GPC['keyword'];
    if (!empty($keyword)) {
        $con .= " AND ( u.nickname LIKE :keyword OR u.realname LIKE :keyword OR u.mobile LIKE :keyword OR b.name LIKE :keyword ) ";
        $par[':keyword'] = "%".$keyword."%";
    }
    $scort = trim($_GPC['scort']);
    if (!empty($scort)) {
        $con .= " AND b.scort LIKE :scort ";
        $par[':scort'] = "%".$scort."%";
    }
    $list = pdo_fetchall("SELECT u.*,b.name FROM ".tablename($this->table_user)." u LEFT JOIN ".tablename($this->table_branch)." b ON u.branchid=b.id ".$con." ORDER BY u.id DESC", $par);
    if (empty($list)) {
        $ret = '<button class="btn btn-default" type="button">未查询到党员信息......</button>';
        exit($ret);
    }else{
        foreach ($list as $k => $v) {
            $ret .= '<button class="btn btn-default" type="button" id="check'.$v['id'].'" style="margin-bottom:5px;margin-right:5px;">'.$v['realname'].' - '.$v['mobile'].' &nbsp;&nbsp; <span onclick="javascript:addUser('.$v['id'].');" class="label label-success">选择</span></button>';
        }
        exit($ret);
    }

} elseif ($op == 'adduser') {
    $ret = array('status'=>"error",'msg'=>"error");
    $activityid = intval($_GPC['activityid']);
    $activity = pdo_get($this->table_activity, array('id'=>$activityid,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        $ret['msg'] = "组织活动信息不存在！";
        exit(json_encode($ret));
    }
    $userid = intval($_GPC['userid']);
    $actenroll = pdo_get($this->table_actenroll,array('userid'=>$userid,'activityid'=>$activityid,'uniacid'=>$_W['uniacid']));
    if (!empty($actenroll)) {
        $ret['msg'] = "该党员已报名过此活动了！";
        exit(json_encode($ret));
    }
    $user = pdo_get($this->table_user,array('id'=>$userid,'uniacid'=>$_W['uniacid']));
    $data = array(
        'uniacid'    => $_W['uniacid'],
        'activityid' => $activityid,
        'userid'     => $userid,
        'utype'      => 2,
        'getval'     => $activity['getval'],
        'createtime' => time(),
        'signintime' => 0
        );
    pdo_insert($this->table_actenroll, $data);
    $id = pdo_insertid();
    $ret['status'] = 'success';
    $ret['msg'] = '<tr><td><input type="checkbox" name="check" value="'.$id.'"> '.$id.'</td><td><strong>'.$user['realname'].'-'.$user['mobile'].'</strong></td><td><a class="label label-primary">指定党员</a></td><td>'.date('Y-m-d H:i').'</td></tr>';
    exit(json_encode($ret));

} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $activity = pdo_fetch("SELECT * FROM ".tablename($this->table_activity)." WHERE id=:id AND branchid IN (".$lbrancharrid.") AND uniacid=:uniacid LIMIT 1 ", array(':id'=>$id,':uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        message_tip('你无权限删除该活动信息！', referer(), 'error');
    }
    pdo_delete($this->table_actenroll, array('activityid'=>$id,'uniacid'=>$_W['uniacid']));
    pdo_delete($this->table_actmessage, array('activityid'=>$id,'uniacid'=>$_W['uniacid']));
    $result = pdo_delete($this->table_activity, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (!empty($result)) {
        message_tip("数据删除成功！",referer(),'success');
    }
    message_tip("数据删除失败，请刷新页面重试！",referer(),'error');

}
include $this->template('admin/activity');
?>