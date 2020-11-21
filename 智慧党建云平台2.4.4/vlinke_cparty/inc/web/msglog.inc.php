<?php
global $_GPC, $_W;
$op = empty($_GPC['op'])?"display":$_GPC['op'];
load()->func('tpl');
if ($op=="display") {
	$con = ' WHERE tab.uniacid=:uniacid ';
	$par[':uniacid'] = $_W['uniacid'];
	$messageid = intval($_GPC['messageid']);
	$message = pdo_get($this->table_msgmessage, array('id'=>$messageid,'uniacid'=>$_W['uniacid']));
	if(!empty($message)){
		$con .= " AND tab.messageid=:messageid ";
		$par[':messageid'] = $messageid;
	}
	$keyword = $_GPC['keyword'];
	if (!empty($keyword)) {
		$con .= " AND ( u.realname LIKE :keyword OR u.mobile LIKE :keyword ) ";
		$par[':keyword'] = "%".$keyword."%";
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall('SELECT tab.*,u.realname,u.mobile,u.headpic,m.templatename,m.title FROM '.tablename($this->table_msglog).' tab LEFT JOIN '.tablename($this->table_user).' u ON tab.userid=u.id LEFT JOIN '.tablename($this->table_msgmessage).' m ON tab.messageid=m.id '.$con.' ORDER BY tab.id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par);
	
	$total = pdo_fetchcolumn('SELECT count(tab.id) FROM '.tablename($this->table_msglog).' tab LEFT JOIN '.tablename($this->table_user).' u ON tab.userid=u.id LEFT JOIN '.tablename($this->table_msgmessage).' m ON tab.messageid=m.id '.$con, $par);
	$pager = pagination($total, $pindex, $psize);

} elseif ($op=="delete") {
	$id = intval($_GPC['id']);
	$result = pdo_delete($this->table_msglog, array('id'=>$id,'uniacid'=>$_W['uniacid']));
	if (!empty($result)) {
		message("数据删除成功！",referer(),'success');
	}
	message("数据删除失败，请刷新页面重试！",referer(),'error');

} elseif ($op=='deleteall') {
    $idstr = implode(",", $_GPC['idArr']);
    $result = pdo_query("delete from ".tablename($this->table_msglog)." WHERE id IN (".$idstr.")");
    if (!empty($result)) {
        exit("success");
    }
    exit("error");
}
include $this->template("msglog");
?>