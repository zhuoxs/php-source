<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {

}elseif ($op=="post") {
    $picall = empty($_GPC['picall'])?array():$_GPC['picall'];
    $data = array(
        'uniacid'    => $_W['uniacid'],
        'userid'     => $user['id'],
        'title'      => trim($_GPC['title']),
        'picall'     => iserializer($picall),
        'details'    => trim($_GPC['details']),
        'createtime' => time()
        );
    pdo_insert($this->table_supreadily, $data);
    message("信息提交成功！", $this->createMobileUrl('supreadily'), 'success');
}elseif ($op=="log") {

}elseif ($op=="getmore") {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_supreadily)." WHERE userid=:userid AND uniacid=:uniacid ORDER BY id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':userid'=>$user['id'],':uniacid'=>$_W['uniacid']));
    if (empty($list)) {
        exit("NOTHAVE");
    }

}elseif ($op=="details") {
    $id = intval($_GPC['id']);
    $supreadily = pdo_get($this->table_supreadily, array('id'=>$id,'userid'=>$user['id'],'uniacid'=>$_W['uniacid']));
    if (empty($supreadily)) {
        message("信件信息不存在！",referer(),'error');
    }
    $supreadily['picall'] = iunserializer($supreadily['picall']);

}
include $this->template('supreadily');
?>