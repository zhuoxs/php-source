<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {



}elseif ($op=="getmore") {
    $pindex = max(1, intval($_GPC['pindex']));
    $psize = max(1, intval($_GPC['psize']));
    $userid = intval($_GPC['userid']);
    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_supproposal)." WHERE userid=:userid AND uniacid=:uniacid ORDER BY id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':userid'=>$userid,':uniacid'=>$_W['uniacid']));
    if (!empty($list)) {
        foreach ($list as $k => $v) {
            $list[$k]['createtime'] = date("Y-m-d H:i", $v['createtime']);
        }
    }
    $this->result(0, '', $list);

}elseif ($op=="post") {
    $data = array(
        'uniacid'    => $_W['uniacid'],
        'userid'     => intval($_GPC['userid']),
        'title'      => trim($_GPC['title']),
        'realname'   => trim($_GPC['realname']),
        'mobile'     => trim($_GPC['mobile']),
        'details'    => trim($_GPC['details']),
        'reply'      => "",
        'status'     => 1,
        'createtime' => time()
        );
    pdo_insert($this->table_supproposal, $data);
    $this->result(0, '', array());


}elseif ($op=="details") {

    $id = intval($_GPC['id']);
    $userid = intval($_GPC['userid']);
    $supproposal = pdo_get($this->table_supproposal, array('id'=>$id,'userid'=>$userid,'uniacid'=>$_W['uniacid']));
    if (empty($supproposal)) {
        $this->result(1, '上报信息不存在！');
    }
    $supproposal['createtime'] = date("Y-m-d H:i", $supproposal['createtime']);
    $this->result(0, '', array(
        'supproposal' => $supproposal
        ));

}
?>