<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {

    $branchid = intval($_GPC['branchid']);
    $branch = pdo_get($this->table_branch, array('id'=>$branchid));

    $brancharr = pdo_fetchall("SELECT id, blevel, name FROM ".tablename($this->table_branch)." WHERE id IN ( ".$branch['scort']." ) AND uniacid=:uniacid ORDER BY field( id,".$branch['scort']." ), priority DESC ", array(':uniacid'=>$_W['uniacid']),"id");
    $luser = pdo_fetchall("SELECT u.id,u.realname,u.mobile,u.headpic,l.leadname,l.branchid FROM ".tablename($this->table_leader)." l LEFT JOIN ".tablename($this->table_user)." u ON l.userid=u.id WHERE l.branchid IN ( ".$branch['scort']." ) AND l.status=1 AND l.uniacid=:uniacid ORDER BY field(l.branchid,".$branch['scort']."), l.priority DESC ", array(':uniacid'=>$_W['uniacid']));
    foreach ($luser as $k => $v) {
        $v['headpic'] = tomedia($v['headpic']);
        $brancharr[$v['branchid']]['luser'][] = $v;
    }
    
    $userall = pdo_fetchall("SELECT * FROM ".tablename($this->table_user)." WHERE branchid=:branchid AND recycle=0 AND status=2 AND uniacid=:uniacid ORDER BY priority DESC, id DESC ", array(':branchid'=>$branchid,':uniacid'=>$_W['uniacid']));
    $ulevelarr = array(1=>"正式党员",2=>"预备党员",3=>"观察对象",4=>"入党积极分子");
    foreach ($userall as $k => $v) {
        $userall[$k]['headpic'] = tomedia($v['headpic']);
        $userall[$k]['ulevelstr'] = $ulevelarr[$v['ulevel']];
    }
    $this->result(0, '', array(
        'brancharr' => $brancharr,
        'userall'   => $userall,
        'branch'    => $branch
        ));


}elseif ($op=="buser") {
    $id = intval($_GPC['id']);
    $buser = pdo_get($this->table_user,array('id'=>$id));
    if (empty($buser)) {
        $this->result(1, '党员档案信息不存在');
    }
    $branch = pdo_get($this->table_branch,array('id'=>$buser['branchid']));
    $buser['headpic'] = tomedia($buser['headpic']);
    $ulevelarr = array(1=>"正式党员",2=>"预备党员",3=>"发展对象",4=>"入党积极分子");
    $buser['ulevelstr'] = $ulevelarr[$buser['ulevel']];

    $leader = pdo_fetchall("SELECT l.leadname,l.branchid,b.name FROM ".tablename($this->table_leader)." l LEFT JOIN ".tablename($this->table_branch)." b ON l.branchid=b.id WHERE l.userid=:userid AND l.branchid IN ( ".$branch['scort']." ) AND l.status=1 AND l.uniacid=:uniacid ORDER BY field(l.branchid,".$branch['scort']."), l.priority DESC ", array(':userid'=>$id,':uniacid'=>$_W['uniacid']));

    $this->result(0, '', array(
        'buser' => $buser,
        'branch' => $branch,
        'leader' => $leader
        ));


}elseif ($op=="details") {
    $id = intval($_GPC['id']);
    $branch = pdo_get($this->table_branch,array('id'=>$id));
    if (empty($branch)) {
        $this->result(1, '组织信息不存在');
    }
    
    $blevelarr = array(1=>"党支部",2=>"党总支",3=>"党委",4=>"单位");
    $branch['blevelstr'] = $blevelarr[$branch['blevel']];

    $branch['details'] = str_replace('<img', '<img style="max-width:100%;height:auto" ', htmlspecialchars_decode($branch['details']));

    $this->result(0, '', array(
        'branch' => $branch
        ));


}
?>