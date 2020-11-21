<?php 
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$cateid = $_GPC['cateid'];
$chid = $_GPC['chid'];

$listV = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and cid = :cid ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':cid' => 0));
$listAll = array();
foreach($listV as $key=>$val) {
    $id = intval($val['id']);
    $listP = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and id = :id ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':id' => $id));
    //var_dump($listP);
    $listS = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_cate') ." WHERE uniacid = :uniacid and cid = :id ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':id' => $id));
    $listP['data'] = $listS;
    array_push($listAll,$listP);
}

return include self::template('web/Cate/display');