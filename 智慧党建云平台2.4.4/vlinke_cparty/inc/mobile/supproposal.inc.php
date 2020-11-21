<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {

}elseif ($op=="post") {
    $data = array(
        'uniacid'    => $_W['uniacid'],
        'userid'     => $user['id'],
        'title'      => trim($_GPC['title']),
        'realname'   => trim($_GPC['realname']),
        'mobile'     => trim($_GPC['mobile']),
        'details'    => trim($_GPC['details']),
        'reply'      => "",
        'status'     => 1,
        'createtime' => time()
        );
    pdo_insert($this->table_supproposal, $data);
    message("信息提交成功！", $this->createMobileUrl('supproposal'), 'success');

}elseif ($op=="log") {

}elseif ($op=="getmore") {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_supproposal)." WHERE userid=:userid AND uniacid=:uniacid ORDER BY id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':userid'=>$user['id'],':uniacid'=>$_W['uniacid']));
    if (empty($list)) {
        exit("NOTHAVE");
    }

}elseif ($op=="details") {
    $id = intval($_GPC['id']);
    $supproposal = pdo_get($this->table_supproposal, array('id'=>$id,'userid'=>$user['id'],'uniacid'=>$_W['uniacid']));
    if (empty($supproposal)) {
        message("信件信息不存在！",referer(),'error');
    }

}
include $this->template('supproposal');
?>