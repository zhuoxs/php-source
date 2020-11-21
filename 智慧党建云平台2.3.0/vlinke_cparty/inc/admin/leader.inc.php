<?php
if ($op=='display') {

    $con = " WHERE l.uniacid=:uniacid AND l.branchid IN (".$lbrancharrid.") ";
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


}elseif ($op == "priority"){
    $priorityarr = $_GPC['priority'];
    $sql = "UPDATE ".tablename($this->table_leader)." SET priority = CASE id ";
    $idstr = "";
    foreach ($priorityarr as $k => $v) {
        $idstr .= $k.",";
        $sql .= " WHEN ".$k." THEN ".$v;
    }
    $sql .=" END WHERE id IN (" . trim($idstr,',') . ")";
    $result = pdo_query($sql);
    if (!empty($result)) {
        message_tip('排序修改成功！', referer(), 'success');
    }else{
        message_tip('排序修改失败，请确认修改数据后重试！', referer(), 'error');
    }


}
include $this->template('admin/leader');
