<?php
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') { 
    $con = " WHERE a.uniacid=:uniacid AND u.branchid IN (".$lbrancharrid.") ";
    $par = array(':uniacid'=>$_W['uniacid']);
    $keywords = trim($_GPC['keywords']);
    if (!empty($keywords)) {
        $con .= " AND ( p.title LIKE :keywords OR u.realname LIKE :keywords OR b.name LIKE :keywords ) ";
        $par[':keywords'] = '%'.$keywords.'%';
    }
    $status = intval($_GPC['status']);
    if ($status!=0) {
        $con .= " AND a.status=:status ";
        $par['status'] = $status;
    }
    $userid = intval($_GPC['userid']);
    if ($userid!=0) {
        $con .= " AND a.userid=:userid ";
        $par['userid'] = $userid;
    }
	$paperid = intval($_GPC['paperid']);
	if ($paperid!=0) {
		$con .= " AND a.paperid=:paperid ";
		$par['paperid'] = $paperid;
	}
    $branchid = intval($_GPC['branchid']);
    if ($branchid!=0) {
        $con .= " AND u.branchid=:branchid ";
        $par['branchid'] = $branchid;
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT a.*,p.title,u.realname,u.mobile,u.branchid,b.name FROM '.tablename($this->table_exaanswer).' a LEFT JOIN '.tablename($this->table_exapaper).' p ON a.paperid=p.id LEFT JOIN '.tablename($this->table_user).' u ON a.userid=u.id LEFT JOIN '.tablename($this->table_branch).' b ON u.branchid=b.id '.$con.' ORDER BY a.id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par, "id");
    $total = pdo_fetchcolumn('SELECT count(a.id) FROM '.tablename($this->table_exaanswer).' a LEFT JOIN '.tablename($this->table_exapaper).' p ON a.paperid=p.id LEFT JOIN '.tablename($this->table_user).' u ON a.userid=u.id LEFT JOIN '.tablename($this->table_branch).' b ON u.branchid=b.id '.$con.' ORDER BY a.id DESC', $par);
    $pager = pagination($total, $pindex, $psize);

    $idstr = implode(",", array_keys($list));

    if (!empty($list)) {
        $exaitemall = pdo_fetchall("SELECT i.*,b.title,b.qtype,b.answer FROM ".tablename($this->table_exaitem)." i LEFT JOIN ".tablename($this->table_exabank)." b ON i.bankid=b.id WHERE i.foreignid IN (".$idstr.") AND i.uniacid=:uniacid AND i.itype=2 ORDER BY i.id ASC", array(':uniacid'=>$_W['uniacid']));
        foreach ($exaitemall as $k => $v) {
            $list[$v['foreignid']]['exaitem'][] = $v;
        }
    }

    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall('SELECT a.*,p.title,u.realname,u.mobile,u.branchid,b.name FROM '.tablename($this->table_exaanswer).' a LEFT JOIN '.tablename($this->table_exapaper).' p ON a.paperid=p.id LEFT JOIN '.tablename($this->table_user).' u ON a.userid=u.id LEFT JOIN '.tablename($this->table_branch).' b ON u.branchid=b.id '.$con.' ORDER BY a.id DESC ', $par, "id");
        foreach($list_out as $k=>$v){
            $data[$k]['id']         = $v['id'];
            $data[$k]['title']      = $v['title'];
            $data[$k]['status']     = $v['status']==1?"未完成":"已完成";
            $data[$k]['aright']     = $v['aright'];
            $data[$k]['awrong']     = $v['awrong'];
            $data[$k]['integral']   = $v['integral'];
            $data[$k]['realname']   = $v['realname'];
            $data[$k]['mobile']     = $v['mobile']."\t";
            $data[$k]['name']       = $v['name'];
            $data[$k]['finishtime'] = $v['finishtime']==0?"未完成":date("Y-m-d H:i",$v['finishtime'])."\t";
            $data[$k]['createtime'] = date("Y-m-d H:i",$v['createtime'])."\t";
        }
        $arrhead = array("ID","标题","状态","答对数目","答错数目","所得积分","姓名","手机号","组织名称","完成时间","创建时间");
        export_excel($data,$arrhead,time());
        exit();
    }

} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $exaanswer = pdo_get($this->table_exaanswer,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($exaanswer)) {
        message_tip('要删除的信息不存在或是已经被删除！', referer(), 'error');
    }
    $user = pdo_fetch('SELECT * FROM '.tablename($this->table_user).' WHERE id=:userid AND uniacid=:uniacid AND branchid IN ('.$lbrancharrid.') ', array(':userid'=>$exaanswer['userid'],':uniacid'=>$_W['uniacid']));
    if (empty($user)) {
        message_tip('你无权删除该记录！', referer(), 'error');
    }
    pdo_delete($this->table_exaitem, array('itype'=>2,'foreignid'=>$id));
    pdo_delete($this->table_exaanswer, array('id' => $id));
    message_tip('信息删除成功！', referer(), 'success');

}
include $this->template('admin/exaanswer');
?>