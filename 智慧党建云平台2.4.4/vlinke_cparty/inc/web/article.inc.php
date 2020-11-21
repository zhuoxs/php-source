<?php
global $_W, $_GPC;
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') { 
    $con = " WHERE uniacid=:uniacid ";
    $par[':uniacid'] = $_W['uniacid'];
    $keywords = trim($_GPC['keywords']);
    if (!empty($keywords)) {
        $con .= " AND title LIKE :keywords ";
        $par[':keywords'] = '%'.$keywords.'%';
    }
    $status = intval($_GPC['status']);
    if ($status!=0) {
        $con .= " AND status=:status ";
        $par[':status'] = $status;
    }
    $cateid = intval($_GPC['cateid']);
    if ($cateid!=0) {
        $con .= " AND cateid=:cateid ";
        $par[':cateid'] = $cateid;
    }
    if (isset($_GPC['branchid'])) {
        $con .= " AND branchid=:branchid ";
        $par[':branchid'] = intval($_GPC['branchid']);
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT * FROM '.tablename($this->table_article).$con.' ORDER BY priority DESC, id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par);
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_article).$con, $par);
    $pager = pagination($total, $pindex, $psize);

    $cateidarr = array_column($list,'cateid');
    $branchidarr = array_column($list,'branchid');

    $artcate = pdo_getall($this->table_artcate, array('uniacid'=>$_W['uniacid']), '', 'id');
    $branch = pdo_getall($this->table_branch, array('id'=>$branchidarr,'uniacid'=>$_W['uniacid']), '', 'id');


} elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    if (checksubmit('submit')) {
        $branchname = trim($_GPC['branchname']);
        if (empty($branchname)) {
            $branchid = 0;
        }else{
            $branchid = intval($_GPC['branchid']);
        }
        $cateid = intval($_GPC['cateid']);
        $data = array(
            'uniacid'  => $_W['uniacid'],
            'cateid'   => $cateid,
            'branchid' => $branchid,
            'title'    => trim($_GPC['title']),
            'link'     => urlencode(trim($_GPC['link'])),
            'tilpic'   => trim($_GPC['tilpic']),
            'details'  => $_GPC['details'],
            'integral' => intval($_GPC['integral']),
            'isslide'  => intval($_GPC['isslide']),
            'slidepic' => trim($_GPC['slidepic']),
            'status'   => intval($_GPC['status']),
            'priority' => intval($_GPC['priority']),
        );
        if (!empty($id)) {
            pdo_update($this->table_article, $data, array('id' => $id));
        } else {
            $data['createtime'] = time();
            pdo_insert($this->table_article, $data);
            $id = pdo_insertid();
        }
        message('信息更新成功！', $this->createWebUrl('article', array('op'=>'display')), 'success');
    }
    $artcate = pdo_getall($this->table_artcate, array('uniacid'=>$_W['uniacid']));
    $article = pdo_fetch("SELECT * FROM ".tablename($this->table_article)." WHERE id=:id AND uniacid=:uniacid LIMIT 1 ", array(':id'=>$id,':uniacid'=>$_W['uniacid']));
    if (empty($article)) {
        $article = array(
            'integral' => 0, 
            'isslide'  => 0,
            'status'   => 2,
            'priority' => 0,
        );
    }else{
		$article['link'] = urldecode($article['link']);
        $branch = pdo_get($this->table_branch,array('id'=>$article['branchid'],'uniacid'=>$_W['uniacid']));
    }
} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    pdo_delete($this->table_artmessage, array('articleid'=>$id,'uniacid'=>$_W['uniacid']));
    $result = pdo_delete($this->table_article, array('id' => $id));
    if (!empty($result)) {
        message("数据删除成功！",referer(),'success');
    }
    message("数据删除失败，请刷新页面重试！",referer(),'error');

} elseif ($op=='deleteall') {
    $idstr = implode(",", $_GPC['idArr']);
    pdo_query("delete from ".tablename($this->table_artmessage)." WHERE articleid IN (".$idstr.")");
    $result = pdo_query("delete from ".tablename($this->table_article)." WHERE id IN (".$idstr.")");
    if (!empty($result)) {
        exit("success");
    }
    exit("error");

}
include $this->template('article');
?>