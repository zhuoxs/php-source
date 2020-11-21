<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {

	$branch = $this->getBranch($user['branchid']);
	$brancharr = pdo_fetchall("SELECT id, blevel, name FROM ".tablename($this->table_branch)." WHERE id IN ( ".$branch['scort']." ) AND uniacid=:uniacid ORDER BY field( id,".$branch['scort']." ), priority DESC ", array(':uniacid'=>$_W['uniacid']),"id");

	$luser = pdo_fetchall("SELECT u.id,u.realname,u.mobile,l.leadname,l.branchid FROM ".tablename($this->table_leader)." l LEFT JOIN ".tablename($this->table_user)." u ON l.userid=u.id WHERE l.branchid IN ( ".$branch['scort']." ) AND l.status=1 AND l.uniacid=:uniacid ORDER BY field(l.branchid,".$branch['scort']."), l.priority DESC ", array(':uniacid'=>$_W['uniacid']));

	foreach ($luser as $k => $v) {
		$brancharr[$v['branchid']]['luser'][] = $v;
	}

}elseif ($op=="post") {
    $data = array(
		'uniacid'    => $_W['uniacid'],
		'userid'     => $user['id'],
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
    message("信息提交成功！", $this->createMobileUrl('supmailbox'), 'success');

}elseif ($op=="log") {

}elseif ($op=="getmore") {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall("SELECT s.*, u.realname FROM ".tablename($this->table_supmailbox)." s LEFT JOIN ".tablename($this->table_user)." u ON s.userid=u.id WHERE s.userid=:userid AND s.uniacid=:uniacid ORDER BY id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':userid'=>$user['id'],':uniacid'=>$_W['uniacid']));
    if (empty($list)) {
        exit("NOTHAVE");
    }

}elseif ($op=="details") {
	$id = intval($_GPC['id']);
    $supmailbox = pdo_get($this->table_supmailbox, array('id'=>$id,'userid'=>$user['id'],'uniacid'=>$_W['uniacid']));
    if (empty($supmailbox)) {
        message("信件信息不存在！",referer(),'error');
    }
    $luser = pdo_get($this->table_user, array('id'=>$supmailbox['luserid'],'uniacid'=>$_W['uniacid']));

}
include $this->template('supmailbox');
?>