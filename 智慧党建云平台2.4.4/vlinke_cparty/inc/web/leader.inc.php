<?php
global $_W,$_GPC;
$op = $operation = $_GPC['op']?$_GPC['op']:'display';
load()->func('tpl');
if ($op=='display') {

    $con = ' WHERE l.uniacid=:uniacid ';
    $par[':uniacid'] = $_W['uniacid'];

    $branchid = intval($_GPC['branchid']);
    if ($branchid!=0) {
        $con .= " AND l.branchid=:branchid ";
        $par[':branchid'] = $branchid;
        $branch = pdo_get($this->table_branch,array('id'=>$branchid,'uniacid'=>$_W['uniacid']));
    }
    $status = intval($_GPC['status']);
    if ($status!=0) {
        $con .= " AND l.status=:status ";
        $par[':status'] = $status;
    }
    $isadmin = intval($_GPC['isadmin']);
    if ($isadmin!=0) {
        $con .= " AND l.isadmin=:isadmin ";
        $par[':isadmin'] = $isadmin;
    }

    $pindex = max(1, intval($_GPC['page']));
    $psize = 50;
    $list = pdo_fetchall("SELECT l.*,u.realname,u.mobile,u.headpic,u.loginname,b.name FROM ".tablename($this->table_leader)." l LEFT JOIN ".tablename($this->table_user)." u ON l.userid=u.id LEFT JOIN ".tablename($this->table_branch)." b ON l.branchid=b.id ".$con." ORDER BY l.priority DESC, l.id DESC LIMIT ".($pindex-1) * $psize.",".$psize, $par);
    $total = pdo_fetchcolumn('SELECT count(l.id) FROM '.tablename($this->table_leader)." l ".$con ,$par);
    $pager = pagination($total, $pindex, $psize);

    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall("SELECT l.*,u.openid,u.nickname,u.realname,u.idnumber,u.mobile,u.headpic,u.loginname,b.name FROM ".tablename($this->table_leader)." l LEFT JOIN ".tablename($this->table_user)." u ON l.userid=u.id LEFT JOIN ".tablename($this->table_branch)." b ON l.branchid=b.id ".$con." ORDER BY l.priority DESC, l.id DESC ",$par);
        $statusarr = array(1=>"显示",2=>"不显示");
        $isadminarr = array(1=>"管理",2=>"不管理");
        foreach($list_out as $k=>$v){
            $data[$k] = array(
                'id'        => $v['id'],
                'branch'    => $v['name'],
                'nickname'  => $v['nickname'],
                'realname'  => $v['realname'],
                'idnumber'  => $v['idnumber']."\t",
                'mobile'    => $v['mobile']."\t",
                'leadname'  => $v['leadname'],
                'status'    => $statusarr[$v['status']],
                'isadmin'   => $statusarr[$v['isadmin']],
                'priority'  => $v['priority'],
                'loginname' => $v['loginname'],
                );
        }
        $arrhead = array("ID","组织关系","昵称","姓名","身份证号","手机号","职称","是否显示在领导栏","是否PC端管理该组织","排序ID","登录用户名");
        export_excel($data,$arrhead,time());
        exit();
    }

} elseif ($op=='post') {
    $id = intval($_GPC['id']);
    $leader = pdo_get($this->table_leader,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (checksubmit('submit')) {
        $branchid = intval($_GPC['branchid']);
        $userid = intval($_GPC['userid']);
        if ($branchid==0 || $userid==0) {
            message('请先选择所属组织以及党员信息！', referer(), 'error');
        }
        $haveleader = pdo_fetch("SELECT * FROM ".tablename($this->table_leader)." WHERE branchid=:branchid AND userid=:userid AND uniacid=:uniacid AND id<>:id ", array(':branchid'=>$branchid,':userid'=>$userid,':uniacid'=>$_W['uniacid'],':id'=>$id));
        if (!empty($haveleader)) {
            message('组织对应管理人员信息已存在！', referer(), 'error');
        }
        $data = array(
            'uniacid'   => $_W['uniacid'],
            'branchid'  => $branchid,
            'userid'    => $userid,
            'leadname'  => trim($_GPC['leadname']),
            'status'    => intval($_GPC['status']),
            'isadmin'   => intval($_GPC['isadmin']),
            'priority'  => intval($_GPC['priority']),
            );
        if ($id==0) {
            pdo_insert($this->table_leader, $data);
        }else{
            pdo_update($this->table_leader, $data, array('id'=>$id));
        }
        message('数据更新成功', $this->createWebUrl('leader'), 'success');
    }
    if (empty($leader)) {
        $leader = array(
            'status'   => 1,
            'isadmin'  => 1,
            'priority' => 0,
            );
    }else{
        $branch = pdo_get($this->table_branch,array('id'=>$leader['branchid'],'uniacid'=>$_W['uniacid']));
        $user = pdo_get($this->table_user,array('id'=>$leader['userid'],'uniacid'=>$_W['uniacid']));
    }

} elseif ($op=='delete') {
    $id = intval($_GPC['id']);
    $leader = pdo_get($this->table_leader,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($leader)) {
        message('要删除的信息不存在或已被删除！', referer(), 'error');
    }
    pdo_delete($this->table_leader, array('id' => $id));
	$leaders = pdo_get($this->table_leader,array('userid'=>$leader['userid'],'uniacid'=>$_W['uniacid']));
	if(empty($leaders)){
		pdo_update($this->table_user, array('loginname'=>"",'loginpass'=>""), array('id'=>$leader['userid'],'uniacid'=>$_W['uniacid']));
	}
    message('管理人员信息删除成功！', referer(), 'success');

} elseif ($op=='setlogin') {
    $userid = intval($_GPC['userid']);
    $user = pdo_get($this->table_user, array("uniacid"=>$_W['uniacid'],"id"=>$userid,"recycle"=>0,"status"=>2));
    if (empty($user)) {
        message('管理者党员账号不存在或账号在非正常状态，请先核查该党员账号！', referer(), 'error');
    }
    $leader = pdo_fetchall("SELECT l.*,b.name FROM ".tablename($this->table_leader)." l LEFT JOIN ".tablename($this->table_branch)." b ON l.branchid=b.id WHERE l.userid=:userid AND l.uniacid=:uniacid ORDER BY l.priority DESC, l.id DESC ", array(':userid'=>$userid,':uniacid'=>$_W['uniacid']));
    if (empty($leader)) {
        message('未有管理组织权限，不必设置管理登录信息！', referer(), 'error');
    }

    if (checksubmit('submit')) {
        $loginname = trim($_GPC['loginname']);
        if (empty($loginname)) {
            message('管理者登录名不能为空！', referer(), 'error');
        }
        $haveuser = pdo_fetch("SELECT * FROM ".tablename($this->table_user)." WHERE loginname=:loginname AND id<>:userid AND uniacid=:uniacid ", array(':loginname'=>$loginname,':userid'=>$userid,':uniacid'=>$_W['uniacid']));
        if (!empty($haveuser)) {
            message('登录用户名已存在！', referer(), 'error');
        }
        $data['loginname'] = $loginname; 
        $loginpass = trim($_GPC['loginpass']);
        if (!empty($loginpass)) {
            $data['loginpass'] = md5($loginpass); 
        }
        pdo_update($this->table_user, $data, array('id'=>$userid));
        message('管理者登录信息修改成功！', referer(), 'success');
    }

}
include $this->template('leader');
