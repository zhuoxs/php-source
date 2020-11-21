<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {

	$branchid = intval($_GPC['branchid']);
	$branch = pdo_get($this->table_branch, array('id'=>$branchid,'uniacid'=>$_W['uniacid']));
	$brancharr = pdo_fetchall("SELECT id, blevel, name FROM ".tablename($this->table_branch)." WHERE id IN ( ".$branch['scort']." ) AND uniacid=:uniacid ORDER BY field( id,".$branch['scort']." ), priority DESC ", array(':uniacid'=>$_W['uniacid']),"id");
	$luser = pdo_fetchall("SELECT u.id,u.realname,u.mobile,u.headpic,l.leadname,l.branchid FROM ".tablename($this->table_leader)." l LEFT JOIN ".tablename($this->table_user)." u ON l.userid=u.id WHERE l.branchid IN ( ".$branch['scort']." ) AND l.status=1 AND l.uniacid=:uniacid ORDER BY field(l.branchid,".$branch['scort']."), l.priority DESC ", array(':uniacid'=>$_W['uniacid']));
	foreach ($luser as $k => $v) {
        $v['headpic'] = tomedia($v['headpic']);
		$brancharr[$v['branchid']]['luser'][] = $v;
	}

	$this->result(0, '', array(
		'brancharr' => $brancharr
        ));


}elseif ($op=="post") {
    $data = array(
		'uniacid'    => $_W['uniacid'],
		'userid'     => intval($_GPC['userid']),
		'luserid'    => intval($_GPC['luserid']),
        'title'      => trim($_GPC['title']),
		'realname'   => trim($_GPC['realname']),
		'mobile'     => trim($_GPC['mobile']),
		'details'    => trim($_GPC['details']),
		'reply'      => "",
		'status'     => 1,
		'createtime' => time()
        );
    pdo_insert($this->table_supmailbox, $data);
    $this->result(0, '', array());


}elseif ($op=="getmore") {

	$pindex = max(1, intval($_GPC['pindex']));
    $psize = max(1, intval($_GPC['psize']));
    $userid = intval($_GPC['userid']);

    $list = pdo_fetchall("SELECT s.*, u.realname as lrealname FROM ".tablename($this->table_supmailbox)." s LEFT JOIN ".tablename($this->table_user)." u ON s.luserid=u.id WHERE s.userid=:userid AND s.uniacid=:uniacid ORDER BY id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':userid'=>$userid,':uniacid'=>$_W['uniacid']));
    if (!empty($list)) {
        foreach ($list as $k => $v) {
            $list[$k]['createtime'] = date("Y-m-d H:i", $v['createtime']);
        }
    }
    $this->result(0, '', $list);


}elseif ($op=="details") {

    $id = intval($_GPC['id']);
    $userid = intval($_GPC['userid']);
    $supmailbox = pdo_get($this->table_supmailbox, array('id'=>$id,'userid'=>$userid,'uniacid'=>$_W['uniacid']));
    if (empty($supmailbox)) {
        $this->result(1, '发件信息不存在！');
    }
    $luser = pdo_get($this->table_user, array('id'=>$supmailbox['luserid']));
    $supmailbox['createtime'] = date("Y-m-d H:i", $supmailbox['createtime']);
    $this->result(0, '', array(
        'supmailbox' => $supmailbox,
        'luser' => $luser
        ));

}
?>