<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {


}elseif ($op=="getmore") {

    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall("SELECT s.*,l.title,l.stustatus FROM ".tablename($this->table_edustudy)." s LEFT JOIN ".tablename($this->table_edulesson)." l ON s.lessonid=l.id WHERE s.userid=:userid AND s.uniacid=:uniacid ORDER BY s.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':userid'=>$user['id'],':uniacid'=>$_W['uniacid']));
    if (empty($list)) {
        exit("NOTHAVE");
    }
    
}
include $this->template('edustudy');
?>