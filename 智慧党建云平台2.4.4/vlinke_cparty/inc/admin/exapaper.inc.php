<?php
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') { 
    $con = " WHERE uniacid=:uniacid ";
    $par = array(':uniacid'=>$_W['uniacid']);
    $keywords = trim($_GPC['keywords']);
    if (!empty($keywords)) {
        $con .= " AND title LIKE :keywords ";
        $par[':keywords'] = '%'.$keywords.'%';
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT * FROM '.tablename($this->table_exapaper).$con.' ORDER BY id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par, "id");
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_exapaper).$con, $par);
    $pager = pagination($total, $pindex, $psize);

    $idstr = implode(",", array_keys($list));
    if (!empty($idstr)) {
        $exapeverytol = pdo_fetchall('SELECT paperid, count(id) as tol FROM '.tablename($this->table_exapevery).' WHERE paperid IN ('.$idstr.') GROUP BY paperid', array(), "paperid");
        $exaanswertol = pdo_fetchall('SELECT a.paperid, count(a.id) as tol FROM '.tablename($this->table_exaanswer).' a LEFT JOIN '.tablename($this->table_user).' u ON a.userid=u.id WHERE a.paperid IN ('.$idstr.') AND u.branchid IN ('.$lbrancharrid.') GROUP BY paperid', array(), "paperid");
    }

}
include $this->template('admin/exapaper');
?>