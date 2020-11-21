<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();

if ($op=="display") {
    
    if ($param['openart']==0) {
        $user = $this->getUser();
    }

    $cateid = intval($_GPC['cateid']);
    $artcatelist = pdo_fetchall("SELECT * FROM ".tablename($this->table_artcate)." WHERE uniacid=:uniacid ORDER BY priority DESC, id DESC", array(':uniacid'=>$_W['uniacid']),'id');

    $artcate = $artcatelist[$cateid];
    if (empty($artcate)) {
        $slide = pdo_fetchall("SELECT * FROM ".tablename($this->table_article)." WHERE status=2 AND isslide=1 AND uniacid=:uniacid ORDER BY priority DESC, id DESC LIMIT 9", array(':uniacid'=>$_W['uniacid']));
    }else{
        $slide = pdo_fetchall("SELECT * FROM ".tablename($this->table_article)." WHERE status=2 AND isslide=1 AND cateid=:cateid AND uniacid=:uniacid ORDER BY priority DESC, id DESC LIMIT 9", array(':cateid'=>$cateid,':uniacid'=>$_W['uniacid']));
    }
    
}elseif ($op=="getmore") {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $con = " WHERE status=2 AND uniacid=:uniacid ";
    $par = array(':uniacid'=>$_W['uniacid']);

    $cateid = intval($_GPC['cateid']);
    if ($cateid!=0) {
        $con .= " AND cateid=:cateid ";
        $par[':cateid'] = $cateid;
    }

    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_article).$con." ORDER BY priority DESC, id DESC LIMIT ".($pindex-1) * $psize.','.$psize, $par);
    if (empty($list)) {
        exit("NOTHAVE");
    }

    $branchidarr = array_column($list,'branchid');
    $branch = pdo_getall($this->table_branch, array('id'=>$branchidarr,'uniacid'=>$_W['uniacid']), '', 'id');

}
include $this->template('artcate');
?>