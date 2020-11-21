<?php
global $_W, $_GPC;
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == "display") {
    $cbranchtol = pdo_fetchcolumn("SELECT count(*) as tol FROM ".tablename($this->table_branch)." WHERE parentid=0 AND uniacid=:uniacid ", array(':uniacid'=>$_W['uniacid']));

    $branchtol = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->table_branch)." WHERE uniacid=:uniacid", array(':uniacid'=>$_W['uniacid']));
    
    $usertol = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->table_user)." WHERE recycle=0 AND uniacid=:uniacid", array(':uniacid'=>$_W['uniacid']));
    $leadertol = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->table_leader)." WHERE uniacid=:uniacid", array(':uniacid'=>$_W['uniacid']));
    
}elseif ($op == "getmore"){
    $parentid = intval($_GPC['parentid']);
    $plevel = intval($_GPC['plevel']);
    $list = pdo_fetchall("SELECT id,scort,name,parentid,blevel,priority FROM ".tablename($this->table_branch)." WHERE uniacid=:uniacid AND parentid=:parentid ORDER BY priority ASC, id ASC ",array(':uniacid'=>$_W['uniacid'],':parentid'=>$parentid),"id");
    $total = count($list);
    if ($total==0) {
        exit("over");
    }
    $keys = implode(",", array_keys($list));
    $usertol = pdo_fetchall("SELECT count(*) as tol, branchid FROM ".tablename($this->table_user)." WHERE recycle=0 AND branchid IN (".$keys.") AND uniacid=:uniacid GROUP BY branchid ", array(':uniacid'=>$_W['uniacid']), "branchid");
    $leadertol = pdo_fetchall("SELECT count(*) as tol, branchid FROM ".tablename($this->table_leader)." WHERE branchid IN (".$keys.") AND uniacid=:uniacid GROUP BY branchid ", array(':uniacid'=>$_W['uniacid']), "branchid");
    $cbranchtol = pdo_fetchall("SELECT count(*) as tol, parentid FROM ".tablename($this->table_branch)." WHERE parentid IN (".$keys.") AND uniacid=:uniacid GROUP BY parentid ", array(':uniacid'=>$_W['uniacid']), "parentid");
    include $this->template('branch_ajax');
    die();

}elseif ($op == "output"){
    $blevelarr = array(1=>"党支部",2=>"党总支",3=>"党委",4=>"单位");
    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_branch). " WHERE uniacid=:uniacid ORDER BY priority ASC, id ASC ", array(':uniacid'=>$_W['uniacid']));
    foreach($list as $k=>$v){
        $data[$k]['id']        = $v['id'];
        $data[$k]['priority']  = $v['priority'];
        $data[$k]['parentid']  = $v['parentid'];
        $data[$k]['name']      = $v['name'];
        $data[$k]['telephone'] = $v['telephone'];
        $data[$k]['address']   = $v['address'];
        $data[$k]['lat']       = $v['lat'];
        $data[$k]['lng']       = $v['lng'];
        $data[$k]['blevel']    = $blevelarr[$v['blevel']];
    }
    $arrhead = array("ID","排序ID","父级组织ID","组织名称","电话","地址","纬度","经度","组织级别");
    export_excel($data,$arrhead,time());
    exit();

}elseif ($op == "post"){
    $id = intval($_GPC['id']);
    $nowbranch = pdo_get($this->table_branch,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (checksubmit('submit')) {
        $branchname = trim($_GPC['branchname']);
        if (empty($branchname)) {
            $parentid = 0;
        }else{
            $parentid = intval($_GPC['branchid']);
        }
        $branch = pdo_get($this->table_branch,array('id'=>$parentid,'uniacid'=>$_W['uniacid']));
        $data = array(
            'uniacid'   => $_W['uniacid'],
            'name'      => trim($_GPC['name']),
            'parentid'  => $parentid,
            'blevel'    => intval($_GPC['blevel']),
            'telephone' => trim($_GPC['telephone']),
            'address'   => trim($_GPC['address']),
            'lat'       => floatval($_GPC['position']['lat']),
            'lng'       => floatval($_GPC['position']['lng']),
            'details'   => trim($_GPC['details']),
            'priority'  => intval($_GPC['priority'])
            );
        if ($id==0) {
            $data['scort'] = empty($branch)?"0":$branch['scort'];
            pdo_insert($this->table_branch, $data);
            $id = pdo_insertid();
            pdo_update($this->table_branch, array('scort'=>$data['scort'].",".$id), array('id'=>$id));
        }else{
            if ($parentid!=$nowbranch['parentid']) {
                $scort = (empty($branch)?"0":$branch['scort']).",".$nowbranch['id'];

                $scort_check = explode(",", $scort);
                $scort_check_res = array_unique($scort_check);
                if ($scort_check != $scort_check_res) {
                    message('所属组织不能是其本身或其下级！', referer(), 'error');
                }

                $sql = "UPDATE ".tablename($this->table_branch)." SET scort = replace(scort, '".$nowbranch['scort']."', '".$scort."') WHERE scort LIKE '".$nowbranch['scort'].",%' AND uniacid=".$_W['uniacid'];
                pdo_query($sql);
                $data['scort'] = $scort;
            }
            pdo_update($this->table_branch, $data, array('id'=>$id));
        }
        message('数据更新成功', $this->createWebUrl('branch',array('op'=>'post','id'=>$id)), 'success');
    }    
    if (empty($nowbranch)) {
        $parentid = 0;
        $nowbranch = array(
            'blevel'   => 1,
            'priority' => 0
            );
    }else{
        $parentid = $nowbranch['parentid'];
        $branch = pdo_get($this->table_branch,array('id'=>$parentid,'uniacid'=>$_W['uniacid']));
    }

}elseif ($op == "priority"){
    $priorityarr = $_GPC['priority'];
    $sql = "UPDATE ".tablename($this->table_branch)." SET priority = CASE id ";
    $idstr = "";
    foreach ($priorityarr as $k => $v) {
        $idstr .= $k.",";
        $sql .= " WHEN ".$k." THEN ".$v;
    }
    $sql .=" END WHERE id IN (" . trim($idstr,',') . ")";
    $result = pdo_query($sql);
    if (!empty($result)) {
        message('排序修改成功！', referer(), 'success');
    }else{
        message('排序修改失败，请确认修改数据后重试！', referer(), 'error');
    }

} elseif ($op == 'delete') {
    $ret = array('status'=>"error",'msg'=>"error");
    $id = intval($_GPC['id']);
    $branch = pdo_get($this->table_branch,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($branch)) {
        $ret['msg'] = "要删除的组织信息不存在！";
        exit(json_encode($ret));
    }
    $cbranch = pdo_get($this->table_branch,array('parentid'=>$id,'uniacid'=>$_W['uniacid']));
    if (!empty($cbranch)) {
        $ret['msg'] = "该组织有下级组织，请先删除其下级组织！";
        exit(json_encode($ret));
    }
    $cuser = pdo_get($this->table_user,array('branchid'=>$id,'uniacid'=>$_W['uniacid']));
    if (!empty($cuser)) {
        $ret['msg'] = "该组织有成员信息，请先处理好组织成员！";
        exit(json_encode($ret));
    }
    pdo_delete($this->table_branch, array('id' => $id));
    $ret['status'] = "success";
    $ret['msg'] = "组织信息删除成功！";
    exit(json_encode($ret));

}
include $this->template('branch');
?>
