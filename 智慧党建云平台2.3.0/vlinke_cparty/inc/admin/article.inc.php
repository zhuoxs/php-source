<?php
load()->func('tpl');
if ($op == 'display') { 
    $con = " WHERE uniacid=:uniacid AND branchid IN (".$lbrancharrid.") ";
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
    $branchid = intval($_GPC['branchid']);
    if ($branchid!=0) {
        $con .= " AND branchid=:branchid ";
        $par[':branchid'] = $branchid;
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT * FROM '.tablename($this->table_article).$con.' ORDER BY priority DESC, id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par);
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_article).$con, $par);
    $pager = pagination($total, $pindex, $psize);

    $artcate = pdo_getall($this->table_artcate, array('uniacid'=>$_W['uniacid']), '', 'id');


} elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    $article = pdo_get($this->table_article, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    $status = intval($article['status']);
    if (checksubmit('submit')) {
        $branchid = intval($_GPC['branchid']);
        $cateid = intval($_GPC['cateid']);
        if ( $branchid==0 || $cateid==0 ) {
            message_tip('发布组织和分类不能为空！', referer(), 'error');
        }
        if ($status > 1) {
            message_tip("该文章已审核归档，不能修改！", referer(), 'error');
        }
        $data = array(
            'uniacid'  => $_W['uniacid'],
            'cateid'   => $cateid,
            'branchid' => $branchid,
            'title'    => trim($_GPC['title']),
            'link'     => trim($_GPC['link']),
            'tilpic'   => trim($_GPC['tilpic']),
            'details'  => $_GPC['details'],
            'integral' => intval($_GPC['integral']),
            'isslide'  => intval($_GPC['isslide']),
            'slidepic' => trim($_GPC['slidepic']),
            'status'   => 1,
            'priority' => 0,
        );
        if (!empty($id)) {
            pdo_update($this->table_article, $data, array('id' => $id));
        } else {
            $data['createtime'] = time();
            pdo_insert($this->table_article, $data);
            $id = pdo_insertid();
        }
        message_tip('信息更新成功！', $this->createWebUrl('admin', array('r'=>'article')), 'success');
    }
    $artcate = pdo_getall($this->table_artcate, array('uniacid'=>$_W['uniacid']));
    if (empty($article)) {
        $article = array(
            'integral' => 0, 
            'isslide'  => 0,
        );
    } else {
        $branch = $lbranchall[$article['branchid']];
        if (empty($branch)) {
            message_tip("你无权限管理该文章信息！", $this->createWebUrl('admin', array('r'=>'article')), 'error');
        }
    }
    
} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $article = pdo_fetch("SELECT * FROM ".tablename($this->table_article)." WHERE id=:id AND branchid IN (".$lbrancharrid.") AND uniacid=:uniacid LIMIT 1 ", array(':id'=>$id,':uniacid'=>$_W['uniacid']));
    if (empty($article)) {
        message_tip("你无权限删除该文章信息！", $this->createWebUrl('admin', array('r'=>'article')), 'error');
    }

    $result = pdo_delete($this->table_article, array('id' => $id));
    if (!empty($result)) {
        message_tip("数据删除成功！",referer(),'success');
    }
    message_tip("数据删除失败，请刷新页面重试！",referer(),'error');

}
include $this->template('admin/article');
?>