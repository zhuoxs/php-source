<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {

    $branch = $this->getBranch($user['branchid']);
    $brancharr = pdo_fetchall("SELECT id, blevel, name FROM ".tablename($this->table_branch)." WHERE id IN ( ".$branch['scort']." ) AND uniacid=:uniacid ORDER BY field( id,".$branch['scort']." ), priority DESC ", array(':uniacid'=>$_W['uniacid']),"id");

    $luser = pdo_fetchall("SELECT u.id,u.headpic,u.realname,u.mobile,l.leadname,l.branchid FROM ".tablename($this->table_leader)." l LEFT JOIN ".tablename($this->table_user)." u ON l.userid=u.id WHERE l.branchid IN ( ".$branch['scort']." ) AND l.status=1 AND l.uniacid=:uniacid ORDER BY field(l.branchid,".$branch['scort']."), l.priority DESC ", array(':uniacid'=>$_W['uniacid']));

    foreach ($luser as $k => $v) {
        $brancharr[$v['branchid']]['luser'][] = $v;
    }

    $ulevelarr = array(1=>"正式党员",2=>"预备党员",3=>"观察对象",4=>"入党积极分子");
    $userall = pdo_fetchall("SELECT * FROM ".tablename($this->table_user)." WHERE branchid=:branchid AND recycle=0 AND status=2 AND uniacid=:uniacid ORDER BY priority DESC, id DESC ", array(':branchid'=>$user['branchid'],':uniacid'=>$_W['uniacid']));


}elseif ($op=="buser") {
    $userid = intval($_GPC['userid']);
    $buser = pdo_get($this->table_user,array('id'=>$userid));
    if (empty($buser)) {
        message("党员档案信息不存在", referer(), 'error');
    }
    $branch = pdo_get($this->table_branch,array('id'=>$buser['branchid']));
    $buser['headpic'] = tomedia($buser['headpic']);
    $ulevelarr = array(1=>"正式党员",2=>"预备党员",3=>"发展对象",4=>"入党积极分子");
    $buser['ulevelstr'] = $ulevelarr[$buser['ulevel']];

    $leader = pdo_fetchall("SELECT l.leadname,l.branchid,b.name FROM ".tablename($this->table_leader)." l LEFT JOIN ".tablename($this->table_branch)." b ON l.branchid=b.id WHERE l.userid=:userid AND l.branchid IN ( ".$branch['scort']." ) AND l.status=1 AND l.uniacid=:uniacid ORDER BY field(l.branchid,".$branch['scort']."), l.priority DESC ", array(':userid'=>$userid,':uniacid'=>$_W['uniacid']));

}elseif ($op=="details") {
    $blevelarr = array(1=>"党支部",2=>"党总支",3=>"党委",4=>"单位");

    $branchid = intval($_GPC['branchid']);
    $branch = pdo_get($this->table_branch,array('id'=>$branchid));

}
include $this->template('mybranch');
?>